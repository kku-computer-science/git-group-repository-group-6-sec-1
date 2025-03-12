*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              chrome
${ROLES_URL}            http://127.0.0.1:8000/roles
${CREATE_URL}           http://127.0.0.1:8000/roles/create
${VALID_ROLE_ID}        3    # เปลี่ยนเป็น ID ที่มีอยู่ในฐานข้อมูลจริง
${VIEW_URL}             http://127.0.0.1:8000/roles/${VALID_ROLE_ID}
${EDIT_URL}             http://127.0.0.1:8000/roles/${VALID_ROLE_ID}/edit
${USERNAME}             admin@gmail.com    # ปรับตามผู้ใช้จริง
${PASSWORD}             12345678           # ปรับตามรหัสผ่านจริง
${LOGIN_URL}            http://127.0.0.1:8000/login
${DASHBOARD_URL}        http://127.0.0.1:8000/dashboard

*** Keywords ***
Open Browser And Login
    Open Browser    ${LOGIN_URL}    ${BROWSER}
    Maximize Browser Window
    Login To System

Login To System
    Wait Until Page Contains Element    id=username    15s
    Log To Console    Found username field
    Input Text    id=username    ${USERNAME}
    Input Text    id=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit']
    Wait Until Location Contains    ${DASHBOARD_URL}    15s
    Log To Console    Login successful, redirected to: ${DASHBOARD_URL}

Reset Language To English
    Go To    ${DASHBOARD_URL}
    Wait Until Page Contains Element    xpath=//a[@class='nav-link dropdown-toggle' and .//span[contains(@class, 'flag-icon')]]    15s
    Click Element    xpath=//a[@class='nav-link dropdown-toggle' and .//span[contains(@class, 'flag-icon')]]
    ${english_present}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//a[@class='dropdown-item' and contains(., 'English')]
    Run Keyword If    ${english_present}    Click Element    xpath=//a[@class='dropdown-item' and contains(., 'English')]
    Wait Until Page Contains Element    xpath=//span[contains(@class, 'flag-icon-us')]    10s
    Log To Console    Reset language to English

Switch Language
    [Arguments]    ${lang}
    Go To    ${DASHBOARD_URL}
    Wait Until Page Contains Element    xpath=//a[@class='nav-link dropdown-toggle' and .//span[contains(@class, 'flag-icon')]]    15s
    Click Element    xpath=//a[@class='nav-link dropdown-toggle' and .//span[contains(@class, 'flag-icon')]]
    Click Element    xpath=//a[contains(@href, 'http://127.0.0.1:8000/lang/${lang}')]
    ${flag}=    Run Keyword If    '${lang}' == 'zh'    Set Variable    cn    ELSE    Set Variable    ${lang}
    Wait Until Page Contains Element    xpath=//span[contains(@class, 'flag-icon-${flag}')]    10s
    Log To Console    Switched to language: ${lang}

Verify Page Language
    [Arguments]    ${expected_text}
    Page Should Contain    ${expected_text}
    Log To Console    Verified text: ${expected_text}

Verify Table Header
    [Arguments]    ${column}    ${expected_text}
    ${actual_text}=    Get Text    xpath=//table//thead//th[${column}]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified table header column ${column}: ${expected_text}


Verify Popup Language
    [Arguments]    ${expected_title}    ${expected_text}    ${expected_success}
    Wait Until Page Contains Element    xpath=//div[contains(@class, 'swal-title')]    15s
    ${title}=    Get Text    xpath=//div[contains(@class, 'swal-title')]
    Should Contain    ${title}    ${expected_title}
    ${text}=     Get Text    xpath=//div[contains(@class, 'swal-text')]
    Should Contain    ${text}    ${expected_text}
    Click Element    xpath=//button[contains(@class, 'swal-button--confirm')]
    Wait Until Page Contains Element    xpath=//div[contains(@class, 'swal-title')]    15s
    ${success}=  Get Text    xpath=//div[contains(@class, 'swal-title')]
    Should Contain    ${success}    ${expected_success}

Logout And Close Browser
    Go To    ${DASHBOARD_URL}
    Wait Until Page Contains Element    xpath=//a[@class='nav-link' and contains(@href, '/logout')]    15s
    Click Element    xpath=//a[@class='nav-link' and contains(@href, '/logout')]
    Wait Until Location Contains    ${LOGIN_URL}    15s
    Log To Console    Logged out successfully
    Close Browser

*** Test Cases ***
TC43_ADMINRoles - ตรวจสอบภาษาส่วนต่างๆ ของ UI19
    [Setup]    Reset Language To English
    Go To    ${ROLES_URL}
    Verify Page Language    Roles
    Verify Page Language    Add
    Verify Page Language    Role Name
    Verify Page Language    Action
    Switch Language    th
    Go To    ${ROLES_URL}
    Verify Page Language    บทบาท
    Verify Page Language    เพิ่ม
    Verify Page Language    ชื่อบทบาท
    Verify Page Language    การกระทำ
    Switch Language    zh
    Go To    ${ROLES_URL}
    Verify Page Language    角色
    Verify Page Language    添加
    Verify Page Language    角色名称
    Verify Page Language    操作

TC42_ADMINRoles_TableTranslation - ตรวจสอบภาษาในตารางของ UI19
    [Setup]    Reset Language To English
    Go To    ${ROLES_URL}
    Log To Console    Starting verification of English table headers...

    # ตรวจสอบคอลัมน์ 1
    ${status1}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table//thead//tr//th[1]    timeout=40s
    Run Keyword If    not ${status1}    Log To Console    Element not found for header 1 after 40s
    ${text1}=    Get Text    xpath=//table//thead//tr//th[1]
    Log To Console    Actual text for header 1: ${text1}
    Run Keyword If    "${text1}" != "#"    Fail    Header 1 mismatch: Expected "#", got "${text1}"
    Log To Console    Successfully verified header 1: Expected "#", Actual "${text1}"

    # ตรวจสอบคอลัมน์ 2
    ${status2}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table//thead//tr//th[2]    timeout=40s
    Run Keyword If    not ${status2}    Log To Console    Element not found for header 2 after 40s
    ${text2}=    Get Text    xpath=//table//thead//tr//th[2]
    Log To Console    Actual text for header 2: ${text2}
    Run Keyword If    "${text2}" != "Role Name"    Fail    Header 2 mismatch: Expected "Role Name", got "${text2}"
    Log To Console    Successfully verified header 2: Expected "Role Name", Actual "${text2}"

    # ตรวจสอบคอลัมน์ 3
    ${status3}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table//thead//tr//th[3]    timeout=40s
    Run Keyword If    not ${status3}    Log To Console    Element not found for header 3 after 40s
    ${text3}=    Get Text    xpath=//table//thead//tr//th[3]
    Log To Console    Actual text for header 3: ${text3}
    Run Keyword If    "${text3}" != "Action"    Fail    Header 3 mismatch: Expected "Action", got "${text3}"
    Log To Console    Successfully verified header 3: Expected "Action", Actual "${text3}"

    Switch Language    th
    Go To    ${ROLES_URL}
    Log To Console    Starting verification of Thai table headers...

    # ตรวจสอบคอลัมน์ 2 ภาษาไทย
    ${text2}=    Get Text    xpath=//table//thead//tr//th[2]
    Run Keyword If    "${text2}" != "ชื่อบทบาท"    Fail    Header 2 mismatch: Expected "ชื่อบทบาท", got "${text2}"
    Log To Console    Successfully verified header 2 in Thai

    # ตรวจสอบคอลัมน์ 3 ภาษาไทย
    ${text3}=    Get Text    xpath=//table//thead//tr//th[3]
    Run Keyword If    "${text3}" != "การกระทำ"    Fail    Header 3 mismatch: Expected "การกระทำ", got "${text3}"
    Log To Console    Successfully verified header 3 in Thai

    Switch Language    zh
    Go To    ${ROLES_URL}
    Log To Console    Starting verification of Chinese table headers...

    # ตรวจสอบคอลัมน์ 2 ภาษาจีน
    ${text2}=    Get Text    xpath=//table//thead//tr//th[2]
    Run Keyword If    "${text2}" != "角色名称"    Fail    Header 2 mismatch: Expected "角色名称", got "${text2}"
    Log To Console    Successfully verified header 2 in Chinese

    # ตรวจสอบคอลัมน์ 3 ภาษาจีน
    ${text3}=    Get Text    xpath=//table//thead//tr//th[3]
    Run Keyword If    "${text3}" != "操作"    Fail    Header 3 mismatch: Expected "操作", got "${text3}"
    Log To Console    Successfully verified header 3 in Chinese
    

TC40_ADMINRoles_FormTranslation - ตรวจสอบภาษาของฟอร์มเพิ่ม Roles ของ UI19
    [Setup]    Reset Language To English
    Go To    ${CREATE_URL}
    Verify Page Language    Create Role
    Verify Page Language    Role Name
    Verify Page Language    Permissions
    Verify Page Language    Submit
    Verify Page Language    Roles List
    Switch Language    th
    Go To    ${CREATE_URL}
    Verify Page Language    สร้างบทบาท
    Verify Page Language    ชื่อบทบาท
    Verify Page Language    สิทธิ์การเข้าถึง
    Verify Page Language    บันทึก
    Verify Page Language    รายการบทบาท
    Switch Language    zh
    Go To    ${CREATE_URL}
    Verify Page Language    创建角色
    Verify Page Language    角色名称
    Verify Page Language    权限
    Verify Page Language    提交
    Verify Page Language    角色列表

TC41_ADMINRoles_ViewTranslation - ตรวจสอบภาษาดูข้อมูล action view ของ UI19
    [Setup]    Reset Language To English
    Go To    ${VIEW_URL}
    Verify Page Language    Roles
    Verify Page Language    Role Name
    Verify Page Language    Role Permissions
    Verify Page Language    Back
    Switch Language    th
    Go To    ${VIEW_URL}
    Verify Page Language    บทบาท
    Verify Page Language    ชื่อบทบาท
    Verify Page Language    สิทธิ์ของบทบาท
    Verify Page Language    ย้อนกลับ
    Switch Language    zh
    Go To    ${VIEW_URL}
    Verify Page Language    角色
    Verify Page Language    角色名称
    Verify Page Language    角色权限
    Verify Page Language    返回

TC44_ADMINRoles_EditTranslation - ตรวจสอบภาษา form action Edit ของ UI19
    [Setup]    Reset Language To English
    Go To    ${EDIT_URL}
    Verify Page Language    Edit Role
    Verify Page Language    Role Name
    Verify Page Language    Permissions
    Verify Page Language    Submit
    Verify Page Language    Back
    Switch Language    th
    Go To    ${EDIT_URL}
    Verify Page Language    แก้ไขบทบาท
    Verify Page Language    ชื่อบทบาท
    Verify Page Language    สิทธิ์การเข้าถึง
    Verify Page Language    บันทึก
    Verify Page Language    ย้อนกลับ
    Switch Language    zh
    Go To    ${EDIT_URL}
    Verify Page Language    编辑角色
    Verify Page Language    角色名称
    Verify Page Language    权限
    Verify Page Language    提交
    Verify Page Language    返回

TC45_ADMINRoles_DeleteTranslation - ตรวจสอบภาษาการลบข้อมูล และ pop up
    [Setup]    Reset Language To English
    Go To    ${ROLES_URL}
    Wait Until Page Contains    Roles    15s
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]

    # ตรวจสอบว่า Popup แสดงขึ้นมาหรือไม่
    ${popup_visible}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//h2[contains(@class, 'swal2-title')]
    Run Keyword If    ${popup_visible}    Verify Popup Language    Are you sure?    If you delete this, it will be gone forever    Deleted successfully

    Switch Language    th
    Go To    ${ROLES_URL}
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    ${popup_visible}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//h2[contains(@class, 'swal2-title')]
    Run Keyword If    ${popup_visible}    Verify Popup Language    คุณแน่ใจหรือไม่?    หากลบแล้ว ข้อมูลจะหายไปตลอดกาล    ลบสำเร็จ

    Switch Language    zh
    Go To    ${ROLES_URL}
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    ${popup_visible}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//h2[contains(@class, 'swal2-title')]
    Run Keyword If    ${popup_visible}    Verify Popup Language    你确定吗？    删除后，数据将无法恢复。    删除成功
