*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Close All Browsers

*** Variables ***
${URL}              http://127.0.0.1:8000
${BROWSER}          Chrome
${USERNAME}         punhor1@kku.ac.th   # ปรับตามผู้ใช้จริง
${PASSWORD}         123456789           # ปรับตามรหัสผ่านจริง
${LOGIN_URL}        http://127.0.0.1:8000/login
${DASHBOARD_URL}    http://127.0.0.1:8000/dashboard
${PROFILE_URL}      http://127.0.0.1:8000/profile

*** Test Cases ***
TC30_REProfile_Dashboard
    [Documentation]    ตรวจสอบภาษาที่ Dashboard
    Go To    ${DASHBOARD_URL}
    Wait Until Page Contains    Dashboard    timeout=10s
    Check Dashboard Translations

TC31_REProfile
    [Documentation]    ตรวจสอบภาษาที่ Profile (แท็บหลัก)
    Go To    ${PROFILE_URL}
    Wait Until Location Contains    ${PROFILE_URL}    timeout=10s
    Check Profile Translations

TC32_REProfile_Account
    [Documentation]    ตรวจสอบภาษาที่ Profile tab Account
    Go To    ${PROFILE_URL}
    Click Element    xpath://a[@id='account-tab']
    Wait Until Element Is Visible    xpath://div[@id='account']    timeout=10s
    Check Account Tab Translations

TC33_REProfile_Password
    [Documentation]    ตรวจสอบภาษาที่ Profile tab Password
    Go To    ${PROFILE_URL}
    Click Element    xpath://a[@id='password-tab']
    Wait Until Element Is Visible    xpath://div[@id='password']    timeout=10s
    Check Password Tab Translations

TC34_REProfile_Expertise
    [Documentation]    ตรวจสอบภาษาที่ Profile tab Expertise
    Go To    ${PROFILE_URL}
    ${expertise_exists}=    Run Keyword And Return Status    Element Should Be Visible    xpath://a[@id='expertise-tab']
    IF    ${expertise_exists}
        Check Expertise Tab
    ELSE
        Log To Console    Expertise tab not available for this user
        Skip    Expertise tab not available
    END

TC35_REProfile_Education
    [Documentation]    ตรวจสอบภาษาที่ Profile tab Education
    Go To    ${PROFILE_URL}
    ${education_exists}=    Run Keyword And Return Status    Element Should Be Visible    xpath://a[@id='education-tab']
    IF    ${education_exists}
        Check Education Tab
    ELSE
        Log To Console    Education tab not available for this user
        Skip    Education tab not available
    END

*** Keywords ***
Open Browser And Login
    Open Browser    ${LOGIN_URL}    ${BROWSER}
    Maximize Browser Window
    Login To System
    Switch Language    th

Login To System
    Wait Until Page Contains Element    id=username    timeout=10s
    Log To Console    Found username field
    Input Text    id=username    ${USERNAME}
    Input Text    id=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit' and contains(text(), 'Login')]
    ${status}=    Run Keyword And Return Status    Wait Until Location Contains    ${DASHBOARD_URL}    timeout=10s
    Run Keyword If    not ${status}    Fail    Login failed or dashboard not loaded
    Log To Console    Login successful, redirected to: ${DASHBOARD_URL}

Switch Language
    [Arguments]    ${lang}
    Go To    ${URL}/lang/${lang}
    Wait Until Page Contains Element    xpath://body    timeout=10s
    Log To Console    Switched to language: ${lang}

Check Text Case Insensitive
    [Arguments]    ${locator}    ${expected_text}
    ${status}=    Run Keyword And Return Status    Wait Until Element Is Visible    ${locator}    timeout=10s
    Run Keyword If    not ${status}    Log To Console    Element ${locator} not visible after 10s
    ${actual_text}=    Get Text    ${locator}
    Log To Console    Actual text found at ${locator}: ${actual_text}
    Run Keyword If    '${actual_text}' == ''    Fail    Empty text found at ${locator}, expected '${expected_text}'
    Should Be Equal As Strings    ${actual_text}    ${expected_text}    ignore_case=True

Check Dashboard Translations
    Set Selenium Timeout    10s
    # Thai
    Switch Language    th
    Wait Until Element Is Visible    xpath://h3[contains(text(), 'ยินดีต้อนรับเข้าสู่ระบบ')]    timeout=10s
    Check Text Case Insensitive    xpath://h3[contains(text(), 'ยินดีต้อนรับเข้าสู่ระบบ')]    ยินดีต้อนรับเข้าสู่ระบบจัดการข้อมูลวิจัยของสาขาวิชาวิทยาการคอมพิวเตอร์
    Wait Until Element Is Visible    xpath://h4[contains(text(), 'สวัสดี')]    timeout=10s
    Element Should Contain    xpath://h4[contains(text(), 'สวัสดี')]    สวัสดี
    # English
    Switch Language    en
    Wait Until Element Is Visible    xpath://h3[contains(text(), 'Welcome to the Research')]    timeout=10s
    Check Text Case Insensitive    xpath://h3[contains(text(), 'Welcome to the Research')]    Welcome to the Research Information Management System for the Department of Computer Science
    Wait Until Element Is Visible    xpath://h4[contains(text(), 'Hello')]    timeout=10s
    Element Should Contain    xpath://h4[contains(text(), 'Hello')]    Hello
    # Chinese
    Switch Language    zh
    Wait Until Element Is Visible    xpath://h3[contains(text(), '欢迎来到计算机科学系')]    timeout=10s
    Check Text Case Insensitive    xpath://h3[contains(text(), '欢迎来到计算机科学系')]    欢迎来到计算机科学系研究信息管理系统
    Wait Until Element Is Visible    xpath://h4[contains(text(), '你好')]    timeout=10s
    Element Should Contain    xpath://h4[contains(text(), '你好')]    你好

Check Profile Translations
    Set Selenium Timeout    10s
    # Thai
    Switch Language    th
    Wait Until Element Is Visible    xpath://h4[contains(@class, 'text-center')]    timeout=10s
    Check Text Case Insensitive    xpath://a[@id='account-tab']//span    บัญชี
    Check Text Case Insensitive    xpath://a[@id='password-tab']//span    รหัสผ่าน
    ${expertise_exists}=    Run Keyword And Return Status    Element Should Be Visible    xpath://a[@id='expertise-tab']//span
    Run Keyword If    ${expertise_exists}    Check Text Case Insensitive    xpath://a[@id='expertise-tab']//span    ความเชี่ยวชาญ
    ${education_exists}=    Run Keyword And Return Status    Element Should Be Visible    xpath://a[@id='education-tab']//span
    Run Keyword If    ${education_exists}    Check Text Case Insensitive    xpath://a[@id='education-tab']//span    การศึกษา
    # English
    Switch Language    en
    Check Text Case Insensitive    xpath://a[@id='account-tab']//span    Account
    Check Text Case Insensitive    xpath://a[@id='password-tab']//span    Password
    Run Keyword If    ${expertise_exists}    Check Text Case Insensitive    xpath://a[@id='expertise-tab']//span    Expertise
    Run Keyword If    ${education_exists}    Check Text Case Insensitive    xpath://a[@id='education-tab']//span    Education
    # Chinese
    Switch Language    zh
    Check Text Case Insensitive    xpath://a[@id='account-tab']//span    账户
    Check Text Case Insensitive    xpath://a[@id='password-tab']//span    密码
    Run Keyword If    ${expertise_exists}    Check Text Case Insensitive    xpath://a[@id='expertise-tab']//span    专长
    Run Keyword If    ${education_exists}    Check Text Case Insensitive    xpath://a[@id='education-tab']//span    教育背景

Check Account Tab Translations
    Set Selenium Timeout    10s
    # Thai
    Switch Language    th
    Check Text Case Insensitive    xpath://div[@id='account']//h3[@class='mb-4']    การตั้งค่าโปรไฟล์  # ปรับจาก //h3 เป็น h3[@class='mb-4'] ตาม HTML
    Check Text Case Insensitive    xpath://div[@id='account']//label[contains(text(), 'ชื่อ')]    ชื่อ (ภาษาอังกฤษ)
    Check Text Case Insensitive    xpath://div[@id='account']//button[@type='submit']    อัปเดต
    # English
    Switch Language    en
    Check Text Case Insensitive    xpath://div[@id='account']//h3[@class='mb-4']    Profile Settings
    Check Text Case Insensitive    xpath://div[@id='account']//label[contains(text(), 'First Name')]    First Name (English)
    Check Text Case Insensitive    xpath://div[@id='account']//button[@type='submit']    Update
    # Chinese
    Switch Language    zh
    Check Text Case Insensitive    xpath://div[@id='account']//h3[@class='mb-4']    个人资料设置
    Check Text Case Insensitive    xpath://div[@id='account']//label[contains(text(), '名字')]    名字 (英文)
    Check Text Case Insensitive    xpath://div[@id='account']//button[@type='submit']    更新

Check Password Tab Translations
    Set Selenium Timeout    10s
    # Thai
    Switch Language    th
    ${h3_exists}=    Run Keyword And Return Status    Element Should Be Visible    xpath://div[@id='password']//h3
    Run Keyword If    ${h3_exists}    Check Text Case Insensitive    xpath://div[@id='password']//h3    การตั้งค่ารหัสผ่าน
    ...    ELSE    Check Password H4 Translations    th  # ตรวจสอบ <h4> แทนถ้า <h3> ไม่มี
    Check Text Case Insensitive    xpath://div[@id='password']//label[contains(text(), 'รหัสผ่านเก่า')]    รหัสผ่านเก่า
    Check Text Case Insensitive    xpath://div[@id='password']//button[@type='submit']    อัปเดต
    # English
    Switch Language    en
    Run Keyword If    ${h3_exists}    Check Text Case Insensitive    xpath://div[@id='password']//h3    Password Settings
    ...    ELSE    Check Password H4 Translations    en
    Check Text Case Insensitive    xpath://div[@id='password']//label[contains(text(), 'Old Password')]    Old Password
    Check Text Case Insensitive    xpath://div[@id='password']//button[@type='submit']    Update
    # Chinese
    Switch Language    zh
    Run Keyword If    ${h3_exists}    Check Text Case Insensitive    xpath://div[@id='password']//h3    密码设置
    ...    ELSE    Check Password H4 Translations    zh
    Check Text Case Insensitive    xpath://div[@id='password']//label[contains(text(), '旧密码')]    旧密码
    Check Text Case Insensitive    xpath://div[@id='password']//button[@type='submit']    更新

Check Password H4 Translations
    [Arguments]    ${lang}
    IF    '${lang}' == 'th'
        Check Text Case Insensitive    xpath://div[@id='password']//h4    การตั้งค่ารหัสผ่าน
    ELSE IF    '${lang}' == 'en'
        Check Text Case Insensitive    xpath://div[@id='password']//h4    Password Settings
    ELSE IF    '${lang}' == 'zh'
        Check Text Case Insensitive    xpath://div[@id='password']//h4    密码设置
    END

Check Expertise Tab
    Click Element    xpath://a[@id='expertise-tab']
    Wait Until Element Is Visible    xpath://div[@id='expertise']    timeout=10s
    # Thai
    Switch Language    th
    ${h3_exists}=    Run Keyword And Return Status    Element Should Be Visible    xpath://div[@id='expertise']//h3
    Run Keyword If    ${h3_exists}    Check Text Case Insensitive    xpath://div[@id='expertise']//h3    ความเชี่ยวชาญ
    ...    ELSE    Check Expertise H4 Translations    th
    Check Text Case Insensitive    xpath://div[@id='expertise']//button[contains(@class, 'btn-menu1')]    เพิ่มความเชี่ยวชาญ
    # English
    Switch Language    en
    Run Keyword If    ${h3_exists}    Check Text Case Insensitive    xpath://div[@id='expertise']//h3    Expertise
    ...    ELSE    Check Expertise H4 Translations    en
    Check Text Case Insensitive    xpath://div[@id='expertise']//button[contains(@class, 'btn-menu1')]    Add Expertise
    # Chinese
    Switch Language    zh
    Run Keyword If    ${h3_exists}    Check Text Case Insensitive    xpath://div[@id='expertise']//h3    专长
    ...    ELSE    Check Expertise H4 Translations    zh
    Check Text Case Insensitive    xpath://div[@id='expertise']//button[contains(@class, 'btn-menu1')]    添加专长

Check Expertise H4 Translations
    [Arguments]    ${lang}
    IF    '${lang}' == 'th'
        Check Text Case Insensitive    xpath://div[@id='expertise']//h4    ความเชี่ยวชาญ
    ELSE IF    '${lang}' == 'en'
        Check Text Case Insensitive    xpath://div[@id='expertise']//h4    Expertise
    ELSE IF    '${lang}' == 'zh'
        Check Text Case Insensitive    xpath://div[@id='expertise']//h4    专长
    END

Check Education Tab
    Click Element    xpath://a[@id='education-tab']
    Wait Until Element Is Visible    xpath://div[@id='education']    timeout=10s
    # Thai
    Switch Language    th
    ${h3_exists}=    Run Keyword And Return Status    Element Should Be Visible    xpath://div[@id='education']//h3
    Run Keyword If    ${h3_exists}    Check Text Case Insensitive    xpath://div[@id='education']//h3    ประวัติการศึกษา
    ...    ELSE    Check Education H4 Translations    th
    Check Text Case Insensitive    xpath://div[@id='education']//label[contains(text(), 'ปริญญาตรี')]    ปริญญาตรี
    Check Text Case Insensitive    xpath://div[@id='education']//button[@type='submit']    อัปเดต
    # English
    Switch Language    en
    Run Keyword If    ${h3_exists}    Check Text Case Insensitive    xpath://div[@id='education']//h3    Educational History
    ...    ELSE    Check Education H4 Translations    en
    Check Text Case Insensitive    xpath://div[@id='education']//label[contains(text(), 'Bachelor')]    Bachelor Degree
    Check Text Case Insensitive    xpath://div[@id='education']//button[@type='submit']    Update
    # Chinese
    Switch Language    zh
    Run Keyword If    ${h3_exists}    Check Text Case Insensitive    xpath://div[@id='education']//h3    教育历史
    ...    ELSE    Check Education H4 Translations    zh
    Check Text Case Insensitive    xpath://div[@id='education']//label[contains(text(), '学士')]    学士学位
    Check Text Case Insensitive    xpath://div[@id='education']//button[@type='submit']    更新

Check Education H4 Translations
    [Arguments]    ${lang}
    IF    '${lang}' == 'th'
        Check Text Case Insensitive    xpath://div[@id='education']//h4    ประวัติการศึกษา
    ELSE IF    '${lang}' == 'en'
        Check Text Case Insensitive    xpath://div[@id='education']//h4    Educational History
    ELSE IF    '${lang}' == 'zh'
        Check Text Case Insensitive    xpath://div[@id='education']//h4    教育历史
    END