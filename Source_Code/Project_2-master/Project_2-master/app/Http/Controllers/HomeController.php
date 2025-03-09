<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Bibtex;
use RenanBr\BibTexParser\Listener;
use RenanBr\BibTexParser\Parser;
use RenanBr\BibTexParser\Processor;

class HomeController extends Controller
{
    public function index()
    {
        $papers = [];
        $year = range(Carbon::now()->year - 4, Carbon::now()->year);
        $years = range(Carbon::now()->year, Carbon::now()->year - 5);

        $from = Carbon::now()->year - 16;
        $to = Carbon::now()->year - 6;

        // ดึงข้อมูลสำหรับช่วงปี 6-16 ปีที่ผ่านมา
        $p2 = Paper::with([
            'teacher' => function ($query) {
                $query->select(DB::raw("CONCAT(concat(left(fname_en,1),'.'),' ',lname_en) as full_name"));
            },
            'author' => function ($query) {
                $query->select(DB::raw("CONCAT(concat(left(author_fname,1),'.'),' ',author_lname) as full_name"));
            },
        ])->whereBetween('paper_yearpub', [$from, $to])->orderBy('paper_yearpub', 'desc')->get()->toArray();

        $paper2 = array_map(function ($tag) {
            $t = collect($tag['teacher']);
            $a = collect($tag['author']);
            $aut = $t->concat($a);
            $sorted = $aut->implode('full_name', ', ');
            return array(
                'id' => $tag['id'],
                'author' => $sorted,
                'paper_name' => $tag['paper_name'],
                'paper_sourcetitle' => $tag['paper_sourcetitle'],
                'paper_type' => $tag['paper_type'],
                'paper_subtype' => $tag['paper_subtype'] ?? null, // เพิ่มการตรวจสอบเพราะตารางไม่มี paper_subtype
                'paper_yearpub' => $tag['paper_yearpub'],
                'paper_url' => $tag['paper_url'],
                'paper_volume' => $tag['paper_volume'],
                'paper_issue' => $tag['paper_issue'],
                'paper_citation' => $tag['paper_citation'],
                'paper_page' => $tag['paper_page'],
                'paper_doi' => $tag['paper_doi'],
            );
        }, $p2);

        // ดึงข้อมูลตามปี
        foreach ($years as $key => $value) {
            $p = Paper::with([
                'teacher' => function ($query) {
                    $query->select(DB::raw("CONCAT(concat(left(fname_en,1),'.'),' ',lname_en) as full_name"));
                },
                'author' => function ($query) {
                    $query->select(DB::raw("CONCAT(concat(left(author_fname,1),'.'),' ',author_lname) as full_name"));
                },
            ])->where('paper_yearpub', '=', $value)->orderBy('paper_yearpub', 'desc')->get()->toArray();

            $paper = array_map(function ($tag) {
                $t = collect($tag['teacher']);
                $a = collect($tag['author']);
                $aut = $t->concat($a);
                $sorted = $aut->implode('full_name', ', ');
                return array(
                    'id' => $tag['id'],
                    'author' => $sorted,
                    'paper_name' => $tag['paper_name'],
                    'paper_sourcetitle' => $tag['paper_sourcetitle'],
                    'paper_type' => $tag['paper_type'],
                    'paper_subtype' => $tag['paper_subtype'] ?? null, // เพิ่มการตรวจสอบเพราะตารางไม่มี paper_subtype
                    'paper_yearpub' => $tag['paper_yearpub'],
                    'paper_url' => $tag['paper_url'],
                    'paper_volume' => $tag['paper_volume'],
                    'paper_issue' => $tag['paper_issue'],
                    'paper_citation' => $tag['paper_citation'],
                    'paper_page' => $tag['paper_page'],
                    'paper_doi' => $tag['paper_doi'],
                );
            }, $p);
            $papers[$value] = collect($paper);
        }

        $papers[$to] = collect($paper2);

        // นับจำนวนตามแหล่งที่มา
        $paper_tci = [];
        $paper_scopus = [];
        $paper_wos = [];

        foreach ($year as $key => $value) {
            $paper_scopus[] = Paper::whereHas('sources', function ($query) {
                return $query->where('source_data_id', '=', 1);
            })->whereIn('paper_type', ['Conference Proceeding', 'Journal'])
                ->where(DB::raw('(paper_yearpub)'), $value)->count();
        }

        foreach ($year as $key => $value) {
            $paper_tci[] = Paper::whereHas('sources', function ($query) {
                return $query->where('source_data_id', '=', 3);
            })->whereIn('paper_type', ['Conference Proceeding', 'Journal'])
                ->where(DB::raw('(paper_yearpub)'), $value)->count();
        }

        foreach ($year as $key => $value) {
            $paper_wos[] = Paper::whereHas('sources', function ($query) {
                return $query->where('source_data_id', '=', 2);
            })->whereIn('paper_type', ['Conference Proceeding', 'Journal'])
                ->where(DB::raw('(paper_yearpub)'), $value)->count();
        }

        $num = $this->getnum();
        $paper_tci_numall = $num['paper_tci'];
        $paper_scopus_numall = $num['paper_scopus'];
        $paper_wos_numall = $num['paper_wos'];

        return view('home', compact('papers'))
            ->with('year', json_encode($year, JSON_NUMERIC_CHECK))
            ->with('paper_tci', json_encode($paper_tci, JSON_NUMERIC_CHECK))
            ->with('paper_scopus', json_encode($paper_scopus, JSON_NUMERIC_CHECK))
            ->with('paper_wos', json_encode($paper_wos, JSON_NUMERIC_CHECK))
            ->with('paper_tci_numall', json_encode($paper_tci_numall, JSON_NUMERIC_CHECK))
            ->with('paper_scopus_numall', json_encode($paper_scopus_numall, JSON_NUMERIC_CHECK))
            ->with('paper_wos_numall', json_encode($paper_wos_numall, JSON_NUMERIC_CHECK));
    }

    public function getnum()
    {
        $paper_scopus = Paper::whereHas('sources', function ($query) {
            return $query->where('source_data_id', '=', 1);
        })->whereIn('paper_type', ['Conference Proceeding', 'Journal'])->count();

        $paper_tci = Paper::whereHas('sources', function ($query) {
            return $query->where('source_data_id', '=', 3);
        })->whereIn('paper_type', ['Conference Proceeding', 'Journal'])->count();

        $paper_wos = Paper::whereHas('sources', function ($query) {
            return $query->where('source_data_id', '=', 2);
        })->whereIn('paper_type', ['Conference Proceeding', 'Journal'])->count();

        return compact('paper_scopus', 'paper_tci', 'paper_wos');
    }

    public function bibtex($id)
    {
        $paper = Paper::with(['author' => function ($query) {
            $query->select('author_name');
        }])->find([$id])->first()->toArray();

        $Path['lib'] = './../lib/';
        require_once $Path['lib'] . 'lib_bibtex.inc.php';

        $Site = array();
        $Site['bibtex'] = new Bibtex('references.bib');
        $bb = $Site['bibtex'];

        $title = $paper['paper_name'];
        $a = collect($paper['author']);
        $author = $a->implode('author_name', ', ');
        $journal = $paper['paper_sourcetitle'];
        $volume = $paper['paper_volume'];
        $number = $paper['paper_citation'];
        $page = $paper['paper_page'];
        $year = $paper['paper_yearpub'];
        $doi = $paper['paper_doi'];

        $key = "kku";
        $arr = array("type" => $type ?? 'article', "key" => "kku", "author" => $author, "title" => $title, "journal" => $journal, "volume" => $volume, "number" => $number, 'year' => $year, 'pages' => $page, 'ee' => $doi);

        $bb->bibarr["kku"] = $arr;
        $key = "kku";

        return response()->json($key, $bb);
    }
}