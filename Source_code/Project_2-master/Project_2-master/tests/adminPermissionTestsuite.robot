*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              Firefox
${PERMISSIONS_URL}      http://127.0.0.1:8000/permissions
${CREATE_URL}           http://127.0.0.1:8000/permissions/create
${VALID_PERMISSION_ID}  1    # เปลี่ยนตาม ID ที่มีจริงในฐานข้อมูล
${VIEW_URL}             http://127.0.0.1:8000/permissions/${VALID_PERMISSION_ID}
${EDIT_URL}             http://127.0.0.1:8000/permissions/${VALID_PERMISSION_ID}/edit
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
    Wait Until Element Is Visible    id=username    timeout=15s
    Input Text    id=username    ${USERNAME}
    Input Text    id=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit']
    Wait Until Location Contains    ${DASHBOARD_URL}    timeout=15s
    Log To Console    Login successful, redirected to: ${DASHBOARD_URL}

Reset Language To English
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=15s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    ${english_present}=    Run Keyword And Return Status    Element Should Be Visible    xpath=//a[contains(., 'English')]
    Run Keyword If    not ${english_present}    Fail    English language option not found
    Click Element    xpath=//a[contains(., 'English')]
    Wait Until Element Is Visible    xpath=//span[contains(@class, 'flag-icon-us')]    timeout=10s
    Wait Until Page Contains    Research Information Management System    timeout=15s
    Log To Console    Reset language to English

Switch Language
    [Arguments]    ${lang}
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=15s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    Click Element    xpath=//a[contains(@href, '/lang/${lang}')]
    ${flag}=    Run Keyword If    '${lang}' == 'zh'    Set Variable    cn    ELSE    Set Variable    ${lang}
    Wait Until Element Is Visible    xpath=//span[contains(@class, 'flag-icon-${flag}')]    timeout=10s
    Run Keyword If    '${lang}' == 'en'    Wait Until Page Contains    Research Information Management System    timeout=15s
    Run Keyword If    '${lang}' == 'th'    Wait Until Page Contains    ระบบจัดการข้อมูลวิจัย    timeout=15s
    Run Keyword If    '${lang}' == 'zh'    Wait Until Page Contains    研究信息管理系统    timeout=15s
    Log To Console    Switched to language: ${lang}

Verify Page Language
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'card-header')]    timeout=15s
    ${actual_text}=    Get Text    xpath=//div[contains(@class, 'card-header')]
    Should Match    ${actual_text}    *${expected_text}*    # เปลี่ยนจาก Should Contain เป็น Should Match เพื่อยืดหยุ่น
    Log To Console    Verified text: ${expected_text}

Verify Button Text
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//button[@type='submit']    timeout=15s
    ${actual_text}=    Get Text    xpath=//button[@type='submit']
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified button text: ${expected_text}

Verify New Permission Button
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'btn btn-primary')]    timeout=15s
    ${actual_text}=    Get Text    xpath=//a[contains(@class, 'btn btn-primary')]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified new permission button text: ${expected_text}

Verify Table Header
    [Arguments]    ${column}    ${expected_text}
    Wait Until Element Is Visible    xpath=//table    timeout=15s    # ตรวจสอบว่าตารางโหลดแล้ว
    Wait Until Element Is Visible    xpath=//table//thead//th[${column}]    timeout=15s
    ${actual_text}=    Get Text    xpath=//table//thead//th[${column}]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified table header column ${column}: ${expected_text}

Verify Popup Language
    [Arguments]    ${expected_title}    ${expected_text}    ${expected_success}
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-title')]    timeout=30s
    ${title}=    Get Text    xpath=//div[contains(@class, 'swal-title')]
    Should Contain    ${title}    ${expected_title}
    ${text}=     Get Text    xpath=//div[contains(@class, 'swal-text')]
    Should Contain    ${text}    ${expected_text}
    Click Element    xpath=//button[contains(@class, 'swal-button--cancel')]
    Reload Page
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'card-header')]    timeout=15s

Logout And Close Browser
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=15s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/logout')]    timeout=15s
    Click Element    xpath=//a[contains(@href, '/logout')]
    Wait Until Location Contains    ${LOGIN_URL}    timeout=15s
    Log To Console    Logged out successfully
    Close Browser

*** Test Cases ***
TC43_ADMINPermission - ตรวจสอบภาษาส่วนต่างๆ ของ UI20
    [Setup]    Reset Language To English
    Go To    ${PERMISSIONS_URL}
    Verify Page Language    Permissions
    Verify New Permission Button    New Permission
    Switch Language    th
    Go To    ${PERMISSIONS_URL}
    Verify Page Language    สิทธิ์การเข้าถึง
    Verify New Permission Button    สร้างสิทธิ์ใหม่
    Switch Language    zh
    Go To    ${PERMISSIONS_URL}
    Verify Page Language    权限
    Verify New Permission Button    创建新权限

TC42_ADMINPermission_TableTranslation - ตรวจสอบภาษาในตารางของ UI20
    [Setup]    Reset Language To English
    Go To    ${PERMISSIONS_URL}
    Verify Table Header    1    #
    Verify Table Header    2    Permission Name
    Verify Table Header    3    Actions
    Switch Language    th
    Go To    ${PERMISSIONS_URL}
    Verify Table Header    1    #
    Verify Table Header    2    ชื่อสิทธิ์
    Verify Table Header    3    การกระทำ
    Switch Language    zh
    Go To    ${PERMISSIONS_URL}
    Verify Table Header    1    #
    Verify Table Header    2    权限名称
    Verify Table Header    3    操作

TC40_ADMINPermission_FormTranslation - ตรวจสอบภาษาของฟอร์มเพิ่ม Permissions ของ UI20
    [Setup]    Reset Language To English
    Go To    ${CREATE_URL}
    Verify Page Language    Create Permission
    Verify Page Language    Permissions List
    Verify Button Text    Save
    Switch Language    th
    Go To    ${CREATE_URL}
    Verify Page Language    สร้างสิทธิ์การเข้าถึง
    Verify Page Language    รายการสิทธิ์การเข้าถึง
    Verify Button Text    บันทึก
    Switch Language    zh
    Go To    ${CREATE_URL}
    Verify Page Language    创建权限
    Verify Page Language    权限列表
    Verify Button Text    保存

TC41_ADMINPermission_ViewTranslation - ตรวจสอบภาษาดูข้อมูล action view ของ UI20
    [Setup]    Reset Language To English
    Go To    ${VIEW_URL}
    Verify Page Language    Permission
    Verify Page Language    Back
    Switch Language    th
    Go To    ${VIEW_URL}
    Verify Page Language    สิทธิ์การเข้าถึง
    Verify Page Language    ย้อนกลับ
    Switch Language    zh
    Go To    ${VIEW_URL}
    Verify Page Language    权限
    Verify Page Language    返回

TC44_ADMINPermission_EditTranslation - ตรวจสอบภาษา form action Edit ของ UI20
    [Setup]    Reset Language To English
    Go To    ${EDIT_URL}
    Verify Page Language    Edit Permission
    Verify Page Language    Permissions List
    Verify Button Text    Save
    Switch Language    th
    Go To    ${EDIT_URL}
    Verify Page Language    แก้ไขสิทธิ์การเข้าถึง
    Verify Page Language    รายการสิทธิ์การเข้าถึง
    Verify Button Text    บันทึก
    Switch Language    zh
    Go To    ${EDIT_URL}
    Verify Page Language    编辑权限
    Verify Page Language    权限列表
    Verify Button Text    保存

TC45_ADMINPermission_DeleteTranslation - ตรวจสอบภาษาการลบข้อมูล และ pop up ที่แสดงขึ้นมา ของ UI20
    [Setup]    Reset Language To English
    Go To    ${PERMISSIONS_URL}
    Wait Until Element Is Visible    xpath=//button[contains(@class, 'show_confirm')][1]    timeout=15s
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify Popup Language    Are you sure?    If you delete this, it will be gone forever    Delete Successfully
    Switch Language    th
    Go To    ${PERMISSIONS_URL}
    Wait Until Element Is Visible    xpath=//button[contains(@class, 'show_confirm')][1]    timeout=15s
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify Popup Language    คุณแน่ใจหรือไม่?    ถ้าคุณลบข้อมูลนี้ มันจะหายไปตลอดกาล    ลบข้อมูลสำเร็จ
    Switch Language    zh
    Go To    ${PERMISSIONS_URL}
    Wait Until Element Is Visible    xpath=//button[contains(@class, 'show_confirm')][1]    timeout=15s
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify Popup Language    你确定吗？    如果你删除这个，它将永远消失。    删除成功