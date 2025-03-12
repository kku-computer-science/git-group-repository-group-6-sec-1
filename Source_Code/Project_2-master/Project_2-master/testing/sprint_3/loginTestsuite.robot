*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browserr

*** Variables ***
${BROWSER}              Chrome
${REUSERNAME}           pusadee@kku.ac.th
${REPASSWORD}           123456789
${ADMINUSERNAME}        admin@gmail.com
${ADMINPASSWORD}        12345678
${INVALID_USERNAME}     raye@uk.com
${INVALID_PASSWORD}     1234567888
${Base_URL}             https://cs6sec267.cpkkuhost.com/
${DASHBOARD_URL}        https://cs6sec267.cpkkuhost.com/dashboard
${LOGIN_URL}            https://cs6sec267.cpkkuhost.com/login
${current_url}          ${EMPTY}
${LANG_DROPDOWN}    xpath=//*[@id="navbarDropdownMenuLink"]
${EN_BUTTON}    xpath=//div[@class='dropdown-menu show']//a[contains(text(), 'English')]
${TH_BUTTON}    xpath=//div[@class='dropdown-menu show']//a[contains(text(), 'ไทย')]
${CH_BUTTON}    xpath=//div[@class='dropdown-menu show']//a[contains(text(), '中文')]

*** Test Cases ***

TC01_Correct_Login
    [Documentation]    ทดสอบการเข้าสู่ระบบด้วย Username และ Password ที่ถูกต้อง ทั้ง 3 ภาษา
    # ทดสอบภาษาอังกฤษ
    Change Language To English
    Verify Login Success    Login
    Verify Login Success    Username
    Verify Login Success    Password
    Verify Login Success    Remember Me
    Verify Login Success    If you forgot your password, please contact the system administrator.
    Verify Login Success    For first-time students, log in with your student ID.
    Verify Login Success    Login Failed: Your user ID or password is incorrect
    Login Input Correct
    Click Logout
    
    # ทดสอบในภาษาไทย
    Change Language To Thai
    Verify Login Success    เข้าสู่ระบบ
    Verify Login Success    ชื่อผู้ใช้
    Verify Login Success    รหัสผ่าน
    Verify Login Success    จดจำฉัน
    Verify Login Success    หากคุณลืมรหัสผ่าน โปรดติดต่อผู้ดูแลระบบ
    Verify Login Success    การเข้าสู่ระบบล้มเหลว: รหัสผู้ใช้หรือรหัสผ่านของคุณไม่ถูกต้อง
    Verify Login Success    สำหรับนักศึกษาครั้งแรก กรุณาเข้าสู่ระบบด้วยรหัสนักศึกษา
    Login Input Correct
    Click Logout
    
    # ทดสอบในภาษาจีน
    Change Language To Chinese
    Verify Login Success    登入
    Verify Login Success    用户名
    Verify Login Success    密码
    Verify Login Success    记住我
    Verify Login Success    如果您忘记了密码，请联系系统管理员。
    Verify Login Success    對於首次入學的學生，請使用學生證登入。
    Verify Login Success    登入失败：您的用户 或密码不正确
    Login Input Correct
    Click Logout

    Close Browser
    Sleep    time_2s

TC02_Correct_Login_Admin
    [Documentation]    ทดสอบการเข้าสู่ระบบด้วย Username และ Password ของ Admin

    Change Language To English
    Verify Login Success    Login
    Verify Login Success    Username
    Verify Login Success    Password
    Verify Login Success    Remember Me
    Verify Login Success    If you forgot your password, please contact the system administrator.
    Verify Login Success    For first-time students, log in with your student ID.
    Verify Login Success    Login Failed: Your user ID or password is incorrect
    Login Input Correct Admin
    Click Logout

    Change Language To Thai
    Verify Login Success    เข้าสู่ระบบ
    Verify Login Success    ชื่อผู้ใช้
    Verify Login Success    รหัสผ่าน
    Verify Login Success    จดจำฉัน
    Verify Login Success    หากคุณลืมรหัสผ่าน โปรดติดต่อผู้ดูแลระบบ
    Verify Login Success    การเข้าสู่ระบบล้มเหลว: รหัสผู้ใช้หรือรหัสผ่านของคุณไม่ถูกต้อง
    Verify Login Success    สำหรับนักศึกษาครั้งแรก กรุณาเข้าสู่ระบบด้วยรหัสนักศึกษา
    Login Input Correct Admin
    Click Logout

    Change Language To Chinese
    Verify Login Success    登入
    Verify Login Success    用户名
    Verify Login Success    密码
    Verify Login Success    记住我
    Verify Login Success    如果您忘记了密码，请联系系统管理员。
    Verify Login Success    對於首次入學的學生，請使用學生證登入。
    Verify Login Success    登入失败：您的用户 或密码不正确
    Login Input Correct Admin
    Click Logout

    # Wait for any last changes
    Wait Until Location Contains    ${LOGIN_URL}    10s

    Sleep    time_5s
    

TC03_Incorrect_Login   
    [Documentation]    ทดสอบการเข้าสู่ระบบด้วย Username และ Password ที่ไม่ถูกต้อง

    # English Test
    Change Language To English
    Login Input Incorrect
    Verify Login Failed Message    Login Failed: Your user ID or password is incorrect

    # Thai Test
    Change Language To Thai
    Login Input Incorrect
    Verify Login Failed Message    การเข้าสู่ระบบล้มเหลว: รหัสผู้ใช้หรือรหัสผ่านของคุณไม่ถูกต้อง
    Sleep    time_2s

    # Chinese Test
    Change Language To Chinese
    Login Input Incorrect
    Verify Login Failed Message    登入失败：您的用户 或密码不正确
    Sleep    time_2s

    Close Browser



*** Keywords ***
Open Browserr
    Open Browser    ${Base_URL}    ${BROWSER}
    Maximize Browser Window
    Click Element   xpath=//a[contains(@class, 'btn-solid-sm')]
    ${handles}=    Get Window Handles
    Switch Window    ${handles}[1]    # สลับไปยังแท็บใหม่
    Wait Until Location Contains    /login    10s
    ${current_url}=    Get Location
    Should Be Equal As Strings    ${current_url}    ${LOGIN_URL}

Login Input Correct
    Input Text    id=username    ${REUSERNAME}
    Input Text    id=password    ${REPASSWORD}
    Click Element   xpath=//button[@type='submit']
    Wait Until Location Contains    ${DASHBOARD_URL}    5s

Login Input Correct Admin
    Input Text    id=username    ${ADMINUSERNAME}
    Input Text    id=password    ${ADMINPASSWORD}
    Click Element   xpath=//button[@type='submit']
    Wait Until Location Contains    ${DASHBOARD_URL}    5s

Login Input Incorrect
    Input Text    id=username    ${INVALID_USERNAME}
    Input Text    id=password    ${INVALID_PASSWORD}
    Click Element   xpath=//button[@type='submit']
    Wait Until Location Contains    ${LOGIN_URL}    8s

Click Logout
    ${current_url}=    Get Location
    Log To Console    Current URL before logout: ${current_url}
    Wait Until Page Contains Element    xpath=//a[@class='nav-link' and .//i[contains(@class, 'mdi-logout')]]    8s
    Click Element    xpath=//a[@class='nav-link' and .//i[contains(@class, 'mdi-logout')]]
    Wait Until Location Contains    ${LOGIN_URL}    8s
    Log To Console    Logged out successfully

Reset Language To English
    Mouse Over    ${LANG_DROPDOWN}
    Sleep    1s
    Click Element    ${LANG_DROPDOWN}
    Wait Until Element Is Visible    ${EN_BUTTON}    timeout=5s
    Click Element    ${EN_BUTTON}
    Sleep    3s

Change Language To English
    Go To    ${Base_URL}/lang/en
    Sleep    5s
    Reload Page
    Wait Until Page Contains    Login    5s

Change Language To Thai
    Go To    ${Base_URL}/lang/th
    Sleep    5s
    Reload Page
    Wait Until Page Contains    เข้าสู่ระบบ    5s

Change Language To Chinese
    Go To    ${Base_URL}/lang/zh
    Sleep    5s
    Reload Page
    Wait Until Page Contains    登入    5s

Verify Login Success
    [Arguments]    ${expected_text}
    Page Should Contain    ${expected_text}    10s
    Log To Console    Verified text: ${expected_text}

Verify Login Failed Message
    [Arguments]    ${expected_text}
    Page Should Contain    ${expected_text}    10s
    Log To Console    Verified text: ${expected_text}

Verify Dashboard Admin
    [Arguments]    ${expected_text}
    Title Should Be    Dashboard - Your Application Name
    Page Should Contain    ${expected_text}    10s
    Log To Console    Verified text: ${expected_text}

