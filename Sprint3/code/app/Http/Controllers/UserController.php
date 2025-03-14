<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Program;
use DB;
use App\Models\User;
use App\Models\Education;  // Add this line to import the Education model
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    /**
     * create a new instance of the class
     *
     * @return void
     */
    function __construct()
    {
         $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index','store']]);
         $this->middleware('permission:user-create', ['only' => ['create','store']]);
         $this->middleware('permission:user-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = User::all();
        //return $data;
        return view('users.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create()
    // {
        
    //     $roles = Role::pluck('name','name')->all();
    //     //$roles = Role::all();
    //     //$deps = Department::pluck('department_name_EN','department_name_EN')->all();
    //     $departments = Department::all();
    //     $programs = Program::with('degree')->get(); 
    //     return view('users.create', compact('roles','departments'));
    //     // $subcat = Program::with('degree')->where('department_id', 1)->get();
    //     // return response()->json($subcat);
    // }

    public function create()
    {

        $roles = \DB::table('roles')->pluck('name', 'name')->mapWithKeys(function ($name) {
            return [$name => __('roles.' . $name)];
        });
        $departments = Department::all();
        $programs = Program::with('degree')->get(); 
        
        // Make sure programs is included in the compact function
        return view('users.create', compact('roles', 'departments', 'programs'));
    }

    
    public function getCategory(Request $request)
{
    $cat = $request->cat_id;
    $lang = $request->lang; // รับค่าภาษาจากคำขอ

    $subcat = Program::with('degree')
        ->where('department_id', $cat)
        ->get();

    // แปลงข้อมูลตามภาษา
    $subcat->transform(function($item) use ($lang) {
        switch ($lang) {
            case 'th':
                $item->degree_title = $item->degree->title_th ?? $item->degree->title_en;
                $item->program_name = $item->program_name_th ?? $item->program_name_en;
                break;
            case 'zh':
                $item->degree_title = $item->degree->title_cn ?? $item->degree->title_en;
                $item->program_name = $item->program_name_cn ?? $item->program_name_en;
                break;
            default:
                $item->degree_title = $item->degree->title_en;
                $item->program_name = $item->program_name_en;
                break;
        }
        return $item;
    });

    return response()->json($subcat);
}


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function store(Request $request)
{
    // Validation
    $this->validate($request, [
        'title_name_en' => 'nullable',
        'title_name_th' => 'nullable',
        'title_name_zh' => 'nullable',
        'fname_en' => 'required',
        'lname_en' => 'required',
        'fname_th' => 'required',
        'lname_th' => 'required',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|confirmed',
        'roles' => 'required',
        'program_id' => 'required|exists:programs,id', // เปลี่ยน sub_cat เป็น program_id ให้ตรงกับฟอร์ม
        'academic_ranks_en' => 'nullable|in:Lecturer,Assistant Professor,Associate Professor,Professor',
        'picture' => 'nullable|image|max:4096',
        // Education validation (optional fields)
        'bachelor_university_th' => 'nullable|string|max:150',
        'bachelor_university_en' => 'nullable|string|max:150',
        'bachelor_university_cn' => 'nullable|string|max:150',
        'bachelor_degree_th' => 'nullable|string|max:150',
        'bachelor_degree_en' => 'nullable|string|max:150',
        'bachelor_degree_cn' => 'nullable|string|max:150',
        'bachelor_year_th' => 'nullable|string|max:4',
        'bachelor_year_en' => 'nullable|string|max:4',
        'master_university_th' => 'nullable|string|max:150',
        'master_university_en' => 'nullable|string|max:150',
        'master_university_cn' => 'nullable|string|max:150',
        'master_degree_th' => 'nullable|string|max:150',
        'master_degree_en' => 'nullable|string|max:150',
        'master_degree_cn' => 'nullable|string|max:150',
        'master_year_th' => 'nullable|string|max:4',
        'master_year_en' => 'nullable|string|max:4',
        'doctoral_university_th' => 'nullable|string|max:150',
        'doctoral_university_en' => 'nullable|string|max:150',
        'doctoral_university_cn' => 'nullable|string|max:150',
        'doctoral_degree_th' => 'nullable|string|max:150',
        'doctoral_degree_en' => 'nullable|string|max:150',
        'doctoral_degree_cn' => 'nullable|string|max:150',
        'doctoral_year_th' => 'nullable|string|max:4',
        'doctoral_year_en' => 'nullable|string|max:4',
    ]);

    // อัปโหลดรูปภาพ
    if ($request->hasFile('picture')) {
        $destinationPath = 'C:/Users/bodin/git-group-repository-group-6-sec-1/Source_Code/Project_2-master/Project_2-master/public/images/imag_user/';
        $file = $request->file('picture');
        $filename = time() . '_' . $file->getClientOriginalName(); // ชื่อไฟล์ไม่ซ้ำ
        $file->move($destinationPath, $filename); // ย้ายไฟล์ไปยังโฟลเดอร์ที่ระบุ
        $data['picture'] = $filename; // บันทึกชื่อไฟล์ใน DB
    }


    // สร้างผู้ใช้ใหม่
    $user = User::create([
        'title_name_en' => $request->title_name_en,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'fname_en' => $request->fname_en,
        'lname_en' => $request->lname_en,
        'fname_th' => $request->fname_th,
        'lname_th' => $request->lname_th,
        'academic_ranks_en' => $request->academic_ranks_en,
        'academic_ranks_th' => $request->academic_ranks_th,
        'academic_ranks_zh' => $request->academic_ranks_zh,
    ]);

    // กำหนดบทบาท (roles)
    $user->assignRole($request->roles);

    // เชื่อมโยงโปรแกรม (program)
    $program = Program::find($request->program_id);
    $user->program()->associate($program)->save();

    // บันทึกข้อมูลการศึกษา (Education)
    if ($request->filled('bachelor_university_th')) {
        Education::create([
            'user_id' => $user->id,
            'level' => 1, // Bachelor
            'uname' => $request->bachelor_university_th,
            'university_en' => $request->bachelor_university_en,
            'university_zh' => $request->bachelor_university_cn,
            'qua_name' => $request->bachelor_degree_th,
            'qua_name_en' => $request->bachelor_degree_en,
            'qua_name_zh' => $request->bachelor_degree_cn,
            'year' => $request->bachelor_year_th,
            'year_anno_domino' => $request->bachelor_year_en,
        ]);
    }

    if ($request->filled('master_university_th')) {
        Education::create([
            'user_id' => $user->id,
            'level' => 2, // Master
            'uname' => $request->master_university_th,
            'university_en' => $request->master_university_en,
            'university_zh' => $request->master_university_cn,
            'qua_name' => $request->master_degree_th,
            'qua_name_en' => $request->master_degree_en,
            'qua_name_zh' => $request->master_degree_cn,
            'year' => $request->master_year_th,
            'year_anno_domino' => $request->master_year_en,
        ]);
    }

    if ($request->filled('doctoral_university_th')) {
        Education::create([
            'user_id' => $user->id,
            'level' => 3, // Doctoral
            'uname' => $request->doctoral_university_th,
            'university_en' => $request->doctoral_university_en,
            'university_zh' => $request->doctoral_university_cn,
            'qua_name' => $request->doctoral_degree_th,
            'qua_name_en' => $request->doctoral_degree_en,
            'qua_name_zh' => $request->doctoral_degree_cn,
            'year' => $request->doctoral_year_th,
            'year_anno_domino' => $request->doctoral_year_en,
        ]);
    }

    return redirect()->route('users.index')
        ->with('success', 'User created successfully.');
}


    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'fname_en' => 'required',
    //         'lname_en' => 'required',
    //         'fname_th' => 'required',
    //         'lname_th' => 'required',
    //         'email' => 'required|email|unique:users,email',
    //         'password' => 'required|confirmed',
    //         'roles' => 'required',
    //         // 'position' => 'required',
    //         'sub_cat' => 'required',
    //     ]);
    
    //     //$input = $request->all();
    //     //$input['password'] = Hash::make($input['password']);
    
    //     //$user = User::create($input);
    //     $user = User::create([  
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'fname_en' => $request->fname_en,
    //         'lname_en' => $request->lname_en,
    //         'fname_th' => $request->fname_th,
    //         'lname_th' => $request->lname_th,
    //         // 'position' =>  $request->position,
    //     ]);
        
    //     $user->assignRole($request->roles);

    //     //dd($request->deps->id);
    //     $pro_id = $request->sub_cat;
    //     //return $pro_id;
    //     //$dep = Program::where('department_name_EN','=',$request->deps)->first()->id;
    //     $program = Program::find($pro_id);

    //     $user = $user->program()->associate($program)->save();

    //     return redirect()->route('users.index')
    //         ->with('success', 'User created successfully.');
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Fetch user by ID
        $user = User::find($id);
    
        // Get the department ID associated with the user's program
        $departmentId = $user->program->department_id;
    
        // Fetch roles and translate them
        $roles = \DB::table('roles')->pluck('name', 'name')->mapWithKeys(function ($name) {
            return [$name => __('roles.' . $name)];
        });
    
        // Fetch education (programs and degrees) related to the department of the user
        $education = Education::where('user_id', $user->id)->get();
    
        // Fetch all departments and programs
        $departments = Department::all();
        $programs = Program::with('degree')->get();
    
        // Fetch department names (use for form select options)
        $deps = Department::pluck('department_name_en', 'department_name_en')->all();
    
        // Fetch roles for the user
        $userRole = $user->roles->pluck('name', 'name')->all();
        $lang = app()->getLocale(); 
    
        // Fetch department for the user
        $userDep = $user->department()->pluck('department_name_en', 'department_name_en')->all();
        $titles = \DB::table('users')
        ->select("title_name_{$lang}")
        ->distinct()
        ->pluck("title_name_{$lang}", "title_name_{$lang}");
    
        // Return the view with required data
        return view('users.edit', compact('user', 'roles', 'deps', 'userRole', 'userDep', 'programs', 'departments', 'education', 'titles', 'lang'));
    }
    

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */



     public function update(Request $request, $id)
{

    $lang = app()->getLocale();
    $titles = \DB::table('users')->select("title_name_{$lang}")->distinct()->pluck("title_name_{$lang}", "title_name_{$lang}");
    // Validate the user input
    $this->validate($request, [
        'title_name_en' => 'required',
        'title_name_th' => 'nullable',
        'title_name_zh' => 'nullable',
        'fname_en' => 'required',
        'fname_th' => 'required',
        'lname_en' => 'required',
        'lname_th' => 'required',
        'email' => 'required|email|unique:users,email,'.$id,
        'password' => 'confirmed',
        'roles' => 'required',
        'picture' => 'nullable|image|max:2048',
        // Add validation for education fields (optional, if required)
        'bachelor_university_th' => 'nullable|string|max:150',
        'bachelor_university_en' => 'nullable|string|max:150',
        'bachelor_university_cn' => 'nullable|string|max:150',
        'bachelor_degree_th' => 'nullable|string|max:150',
        'bachelor_degree_en' => 'nullable|string|max:150',
        'bachelor_degree_cn' => 'nullable|string|max:150',
        'bachelor_year_th' => 'nullable|string|max:4',
        'bachelor_year_en' => 'nullable|string|max:4',
        'master_university_th' => 'nullable|string|max:150',
        'master_university_en' => 'nullable|string|max:150',
        'master_university_cn' => 'nullable|string|max:150',
        'master_degree_th' => 'nullable|string|max:150',
        'master_degree_en' => 'nullable|string|max:150',
        'master_degree_cn' => 'nullable|string|max:150',
        'master_year_th' => 'nullable|string|max:4',
        'master_year_en' => 'nullable|string|max:4',
        'doctoral_university_th' => 'nullable|string|max:150',
        'doctoral_university_en' => 'nullable|string|max:150',
        'doctoral_university_cn' => 'nullable|string|max:150',
        'doctoral_degree_th' => 'nullable|string|max:150',
        'doctoral_degree_en' => 'nullable|string|max:150',
        'doctoral_degree_cn' => 'nullable|string|max:150',
        'doctoral_year_th' => 'nullable|string|max:4',
        'doctoral_year_en' => 'nullable|string|max:4',

    ]);

    if ($request->hasFile('picture')) {
        $path = 'images/imag_user/';
        $file = $request->file('picture');
        $new_name = $user->fname_en . '.jpg';

        // ลบรูปเก่าถ้ามี
        if ($user->picture && File::exists(public_path($path . $user->picture))) {
            File::delete(public_path($path . $user->picture));
        }

        $file->move(public_path($path), $new_name);
        $data['picture'] = $new_name;
    }

    $user->update($data);

    // Get the user data
    $input = $request->all();
    
    // Handle password hashing if a new password is provided
    if (!empty($input['password'])) { 
        $input['password'] = Hash::make($input['password']);
    } else {
        $input = Arr::except($input, ['password']);    
    }

    // Find the user and update their information
    $user = User::find($id);
    $user->update($input);

    // Update roles for the user (deleting old roles first)
    DB::table('model_has_roles')
        ->where('model_id', $id)
        ->delete();
    
    $user->assignRole($request->input('roles'));

    // Update program association
    $pro_id = $request->sub_cat;
    $program = Program::find($pro_id);
    $user->program()->associate($program)->save();


    $bachelor = Education::where('level', 1)->where('user_id', $id)->first();
    if ($bachelor) {
        $bachelor->uname = $request->input('bachelor_university_th') ?? $bachelor->uname; // ป้องกัน NULL
        $bachelor->university_en = $request->input('bachelor_university_en') ?? $bachelor->university_en;
        $bachelor->university_zh = $request->input('bachelor_university_cn') ?? $bachelor->university_zh;
        $bachelor->qua_name = $request->input('bachelor_degree_th') ?? $bachelor->qua_name;
        $bachelor->qua_name_en = $request->input('bachelor_degree_en') ?? $bachelor->qua_name_en;
        $bachelor->qua_name_zh = $request->input('bachelor_degree_cn') ?? $bachelor->qua_name_zh;
        $bachelor->year = $request->input('bachelor_year_th') ?? $bachelor->year;
        $bachelor->year_anno_domino = $request->input('bachelor_year_en') ?? $bachelor->year_anno_domino;
        $bachelor->save();
    }

    $master = Education::where('level', 2)->where('user_id', $id)->first();
    if ($master) {
        $master->uname = $request->input('master_university_th') ?? $master->uname; // ป้องกัน NULL
        $master->university_en = $request->input('master_university_en') ?? $master->university_en;
        $master->university_zh = $request->input('master_university_cn') ?? $master->university_zh;
        $master->qua_name = $request->input('master_degree_th') ?? $master->qua_name;
        $master->qua_name_en = $request->input('master_degree_en') ?? $master->qua_name_en;
        $master->qua_name_zh = $request->input('master_degree_cn') ?? $master->qua_name_zh;
        $master->year = $request->input('master_year_th') ?? $master->year;
        $master->year_anno_domino = $request->input('master_year_en') ?? $master->year_anno_domino;
        $master->save();
    }

    $doctoral = Education::where('level', 3)->where('user_id', $id)->first();
    if ($doctoral) {
        $doctoral->uname = $request->input('doctoral_university_th') ?? $doctoral->uname; // ป้องกัน NULL
        $doctoral->university_en = $request->input('doctoral_university_en') ?? $doctoral->university_en;
        $doctoral->university_zh = $request->input('doctoral_university_cn') ?? $doctoral->university_zh;
        $doctoral->qua_name = $request->input('doctoral_degree_th') ?? $doctoral->qua_name;
        $doctoral->qua_name_en = $request->input('doctoral_degree_en') ?? $doctoral->qua_name_en;
        $doctoral->qua_name_zh = $request->input('doctoral_degree_cn') ?? $doctoral->qua_name_zh;
        $doctoral->year = $request->input('doctoral_year_th') ?? $doctoral->year;
        $doctoral->year_anno_domino = $request->input('doctoral_year_en') ?? $doctoral->year_anno_domino;
        $doctoral->save();
    }

    return redirect()->route('users.index')->with('success', 'อัปเดตสำเร็จ');

    // if ($request->has('bachelor_university_th')) {
    //     $bachelor = Education::where('level', 1)->where('user_id', $id)->first();
    //     if ($bachelor) {
    //         $bachelor->update([
    //             'uname' => $request->input('bachelor_university_th'),
    //             'university_en' => $request->input('bachelor_university_en'),
    //             'university_zh' => $request->input('bachelor_university_cn'),
    //             'qua_name' => $request->input('bachelor_degree_th'),
    //             'qua_name_en' => $request->input('bachelor_degree_en'),
    //             'qua_name_zh' => $request->input('bachelor_degree_cn'),
    //             'year' => $request->input('bachelor_year_th'),
    //             'year_anno_domino' => $request->input('bachelor_year_en'),
                
    //         ]);
    //     } else {
    //         Education::create([
    //             'user_id' => $id,
    //             'level' => 1,
    //             'uname' => $request->input('bachelor_university_th'),
    //             'university_en' => $request->input('bachelor_university_en'),
    //             'university_zh' => $request->input('bachelor_university_cn'),
    //             'qua_name' => $request->input('bachelor_degree_th'),
    //             'qua_name_en' => $request->input('bachelor_degree_en'),
    //             'qua_name_zh' => $request->input('bachelor_degree_cn'),
    //             'year' => $request->input('bachelor_year_th'),
    //             'year_anno_domino' => $request->input('bachelor_year_en'),
    //         ]);
    //     }
    // }

    if ($request->has('master_university_th')) {
        $master = Education::where('level', 2)->where('user_id', $id)->first();
        if ($master) {
            $master->update([
                'uname' => $request->input('master_university_th'),
                'university_en' => $request->input('master_university_en'),
                'university_zh' => $request->input('master_university_cn'),
                'qua_name' => $request->input('master_degree_th'),
                'qua_name_en' => $request->input('master_degree_en'),
                'qua_name_zh' => $request->input('master_degree_cn'),
                'year' => $request->input('master_year_th'),
                'year_anno_domino' => $request->input('master_year_en'),
            ]);
        } else {
            Education::create([
                'user_id' => $id,
                'level' => 2,
                'uname' => $request->input('master_university_th'),
                'university_en' => $request->input('master_university_en'),
                'university_zh' => $request->input('master_university_cn'),
                'qua_name' => $request->input('master_degree_th'),
                'qua_name_en' => $request->input('master_degree_en'),
                'qua_name_zh' => $request->input('master_degree_cn'),
                'year' => $request->input('master_year_th'),
                'year_anno_domino' => $request->input('master_year_en'),
            ]);
        }
    }

    if ($request->has('doctoral_university_th')) {
        $doctoral = Education::where('level', 3)->where('user_id', $id)->first();
        if ($doctoral) {
            $doctoral->update([
                'uname' => $request->input('doctoral_university_th'),
                'university_en' => $request->input('doctoral_university_en'),
                'university_zh' => $request->input('doctoral_university_cn'),
                'qua_name' => $request->input('doctoral_degree_th'),
                'qua_name_en' => $request->input('doctoral_degree_en'),
                'qua_name_zh' => $request->input('doctoral_degree_cn'),
                'year' => $request->input('doctoral_year_th'),
                'year_anno_domino' => $request->input('doctoral_year_en'),
            ]);
        } else {
            Education::create([
                'user_id' => $id,
                'level' => 3,
                'uname' => $request->input('doctoral_university_th'),
                'university_en' => $request->input('doctoral_university_en'),
                'university_zh' => $request->input('doctoral_university_cn'),
                'qua_name' => $request->input('doctoral_degree_th'),
                'qua_name_en' => $request->input('doctoral_degree_en'),
                'qua_name_zh' => $request->input('doctoral_degree_cn'),
                'year' => $request->input('doctoral_year_th'),
                'year_anno_domino' => $request->input('doctoral_year_en'),
            ]);
        }
    }
    $bachelor = Education::where('level', 1)->where('user_id', $id)->first();
    if ($bachelor) {
        $bachelor->uname = $request->input('bachelor_university_th');
        $bachelor->save();
        dd($bachelor->getChanges());
    }

    // Return the success message
    return redirect()->route('users.index')
        ->with('success', 'User and education updated successfully.');
}


    // public function update(Request $request, $id)
    // {
    //     $this->validate($request, [
    //         'fname_en' => 'required',
    //         'fname_th' => 'required',
    //         'lname_en' => 'required',
    //         'lname_th' => 'required',
    //         'email' => 'required|email|unique:users,email,'.$id,
    //         'password' => 'confirmed',
    //         'roles' => 'required'
    //     ]);
    
    //     $input = $request->all();
        
    //     if(!empty($input['password'])) { 
    //         $input['password'] = Hash::make($input['password']);
    //     } else {
    //         $input = Arr::except($input, array('password'));    
    //     }
    
    //     $user = User::find($id);
    //     $user->update($input);

    //     DB::table('model_has_roles')
    //         ->where('model_id', $id)
    //         ->delete();
    
    //     $user->assignRole($request->input('roles'));
    //     $pro_id = $request->sub_cat;
    //     $program = Program::find($pro_id);
    //     $user = $user->program()->associate($program)->save();

    //     return redirect()->route('users.index')
    //         ->with('success', 'User updated successfully.');
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }

    function profile(){
        return view('dashboards.users.profile');
    }

    function updatePicture(Request $request){
        $path = 'images/imag_user/';
        //return 'aaaaaa';
        $file = $request->file('admin_image');
       $new_name = 'UIMG_'.date('Ymd').uniqid().'.jpg';
        
        //dd(public_path());
        //Upload new image
        $upload = $file->move(public_path($path), $new_name);
        //$filename = time() . '.' . $file->getClientOriginalExtension();
        //$upload = $file->move('user/images', $filename);
     
        if( !$upload ){
            return response()->json(['status'=>0,'msg'=>'Something went wrong, upload new picture failed.']);
        }else{
            //Get Old picture
            $oldPicture = User::find(Auth::user()->id)->getAttributes()['picture'];

            if( $oldPicture != '' ){
                if( \File::exists(public_path($path.$oldPicture))){
                    \File::delete(public_path($path.$oldPicture));
                }
            }

            //Update DB
            $update = User::find(Auth::user()->id)->update(['picture'=>$new_name]);

            if( !$upload ){
                return response()->json(['status'=>0,'msg'=>'Something went wrong, updating picture in db failed.']);
            }else{
                return response()->json(['status'=>1,'msg'=>'Your profile picture has been updated successfully']);
            }
        }
    }
    
    public function updateUserPicture(Request $request, $id)
{
    $path = 'images/imag_user/';

    // Validate the request
    $request->validate([
        'user_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Check if file is uploaded
    if (!$request->hasFile('user_image')) {
        return response()->json(['status' => 0, 'msg' => 'No image file uploaded.']);
    }

    $file = $request->file('user_image');
    $user = User::findOrFail($id); // Ensure user exists
    $new_name = $user->fname_en . '_' . date('Ymd') . uniqid() . '.jpg'; // Use first name

    // Move the file
    $upload = $file->move(public_path($path), $new_name);
    if (!$upload) {
        return response()->json(['status' => 0, 'msg' => 'Something went wrong, upload failed.']);
    }

    // Delete old picture if exists
    if ($user->picture) {
        $oldPicturePath = public_path($path . $user->picture);
        if (\File::exists($oldPicturePath)) {
            \File::delete($oldPicturePath); // Delete old picture file
        }
    }

    // Update database with the new image name
    $user->update(['picture' => $new_name]);

    return response()->json([
        'status' => 1,
        'filename' => $new_name,
        'msg' => 'User profile picture updated successfully'
    ]);
}





    
    
    

}
