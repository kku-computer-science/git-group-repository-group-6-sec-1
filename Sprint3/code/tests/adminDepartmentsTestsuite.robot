*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              Firefox
${DEPARTMENTS_URL}      http://127.0.0.1:8000/departments
${CREATE_URL}           http://127.0.0.1:8000/departments/create
${VALID_DEPARTMENT_ID}  1    # เปลี่ยนตาม ID ที่มีจริงในฐานข้อมูล
${VIEW_URL}             http://127.0.0.1:8000/departments/${VALID_DEPARTMENT_ID}
${EDIT_URL}             http://127.0.0.1:8000/departments/${VALID_DEPARTMENT_ID}/edit
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
    Wait Until Element Is Visible    id=username    timeout=20s
    Input Text    id=username    ${USERNAME}
    Input Text    id=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit']
    Wait Until Location Contains    ${DASHBOARD_URL}    timeout=20s
    Log To Console    Login successful, redirected to: ${DASHBOARD_URL}

Reset Language To English
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=20s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    ${english_present}=    Run Keyword And Return Status    Element Should Be Visible    xpath=//a[contains(., 'English')]
    Run Keyword If    not ${english_present}    Fail    English language option not found
    Click Element    xpath=//a[contains(., 'English')]
    Wait Until Element Is Visible    xpath=//span[contains(@class, 'flag-icon-us')]    timeout=15s
    Wait Until Page Contains    Research Information Management System    timeout=20s
    Log To Console    Reset language to English

Switch Language
    [Arguments]    ${lang}
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=20s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    Click Element    xpath=//a[contains(@href, '/lang/${lang}')]
    ${flag}=    Run Keyword If    '${lang}' == 'zh'    Set Variable    cn    ELSE    Set Variable    ${lang}
    Wait Until Element Is Visible    xpath=//span[contains(@class, 'flag-icon-${flag}')]    timeout=15s
    Run Keyword If    '${lang}' == 'en'    Wait Until Page Contains    Research Information Management System    timeout=20s
    Run Keyword If    '${lang}' == 'th'    Wait Until Page Contains    ระบบจัดการข้อมูลวิจัย    timeout=20s
    Run Keyword If    '${lang}' == 'zh'    Wait Until Page Contains    研究信息管理系统    timeout=20s
    Log To Console    Switched to language: ${lang}

Verify Page Language
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'card-header')]    timeout=25s    # ปรับ xpath และเพิ่ม timeout
    ${actual_text}=    Get Text    xpath=//div[contains(@class, 'card-header')]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified text: ${expected_text} (Actual: ${actual_text})

Verify Button Text
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//button[@type='submit']    timeout=20s
    ${actual_text}=    Get Text    xpath=//button[@type='submit']
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified button text: ${expected_text}

Verify New Department Button
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'btn btn-primary')]    timeout=20s
    ${actual_text}=    Get Text    xpath=//a[contains(@class, 'btn btn-primary')]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified new department button text: ${expected_text}

Verify Departments List Button
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'btn btn-primary') and contains(@href, 'departments')]    timeout=20s
    ${actual_text}=    Get Text    xpath=//a[contains(@class, 'btn btn-primary') and contains(@href, 'departments')]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified departments list button text: ${expected_text}

Verify Back Button
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'btn btn-primary') and contains(@href, 'departments')]    timeout=20s
    ${actual_text}=    Get Text    xpath=//a[contains(@class, 'btn btn-primary') and contains(@href, 'departments')]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified back button text: ${expected_text}

Verify Table Header
    [Arguments]    ${column}    ${expected_text}
    Wait Until Element Is Visible    xpath=//table    timeout=20s
    Wait Until Element Is Visible    xpath=//table//thead//th[${column}]    timeout=20s
    ${actual_text}=    Get Text    xpath=//table//thead//th[${column}]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified table header column ${column}: ${expected_text} (Actual: ${actual_text})

Verify Popup Language
    [Arguments]    ${expected_title}    ${expected_text}    ${expected_success}
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-title')]    timeout=30s
    ${title}=    Get Text    xpath=//div[contains(@class, 'swal-title')]
    Should Contain    ${title}    ${expected_title}
    ${text}=     Get Text    xpath=//div[contains(@class, 'swal-text')]
    Should Contain    ${text}    ${expected_text}
    Click Element    xpath=//button[contains(., 'Cancel') or contains(., 'ยกเลิก') or contains(., '取消')]
    Reload Page
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'card-header')]    timeout=20s
    Log To Console    Verified popup: ${expected_title} - ${expected_text}

Logout And Close Browser
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=20s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/logout')]    timeout=20s
    Click Element    xpath=//a[contains(@href, '/logout')]
    Wait Until Location Contains    ${LOGIN_URL}    timeout=20s
    Log To Console    Logged out successfully
    Close Browser

*** Test Cases ***
TC43_ADMINDepartments - ตรวจสอบภาษาสส่วนต่างๆ ของ UI21
    [Setup]    Reset Language To English
    Go To    ${DEPARTMENTS_URL}
    Verify Page Language    Departments
    Verify New Department Button    New Department
    Switch Language    th
    Go To    ${DEPARTMENTS_URL}
    Verify Page Language    แผนก
    Verify New Department Button    สร้างแผนกใหม่
    Switch Language    zh
    Go To    ${DEPARTMENTS_URL}
    Verify Page Language    部门
    Verify New Department Button    新建部门

TC42_ADMINDepartments_TableTranslation - ตรวจสอบภาษาในตารางของ UI21
    [Setup]    Reset Language To English
    Go To    ${DEPARTMENTS_URL}
    Verify Table Header    1    #
    Verify Table Header    2    Department Name
    Verify Table Header    3    Action
    Switch Language    th
    Go To    ${DEPARTMENTS_URL}
    Verify Table Header    1    #
    Verify Table Header    2    ชื่อแผนก
    Verify Table Header    3    การกระทำ
    Switch Language    zh
    Go To    ${DEPARTMENTS_URL}
    Verify Table Header    1    #
    Verify Table Header    2    部门名称
    Verify Table Header    3    操作

TC40_ADMINDepartments_FormTranslation - ตรวจสอบภาษาของฟอร์มเพิ่ม Departments ของ UI21
    [Setup]    Reset Language To English
    Go To    ${CREATE_URL}
    Verify Page Language    Create Department
    Verify Departments List Button    Departments List    # ใช้ Departments List แทน Department List
    Verify Button Text    Submit
    Switch Language    th
    Go To    ${CREATE_URL}
    Verify Page Language    สร้างแผนก
    Verify Departments List Button    รายการแผนก
    Verify Button Text    บันทึก
    Switch Language    zh
    Go To    ${CREATE_URL}
    Verify Page Language    创建部门
    Verify Departments List Button    部门列表
    Verify Button Text    提交

TC41_ADMINDepartments_ViewTranslation - ตรวจสอบภาษาดูข้อมูล action view ของ UI21
    [Setup]    Reset Language To English
    Go To    ${VIEW_URL}
    Verify Page Language    Department Details
    Verify Back Button    Back
    Switch Language    th
    Go To    ${VIEW_URL}
    Verify Page Language    รายละเอียดแผนก
    Verify Back Button    ย้อนกลับ
    Switch Language    zh
    Go To    ${VIEW_URL}
    Verify Page Language    部门详情
    Verify Back Button    返回

TC41_ADMINDepartments_EditTranslation - ตรวจสอบภาษา form action Edit ของ UI21
    [Setup]    Reset Language To English
    Go To    ${EDIT_URL}
    Verify Page Language    Edit Department
    Verify Departments List Button    Departments List    # ใช้ Departments List แทน Department List
    Verify Button Text    Submit
    Switch Language    th
    Go To    ${EDIT_URL}
    Verify Page Language    แก้ไขแผนก
    Verify Departments List Button    รายการแผนก
    Verify Button Text    บันทึก
    Switch Language    zh
    Go To    ${EDIT_URL}
    Verify Page Language    编辑部门
    Verify Departments List Button    部门列表
    Verify Button Text    提交

TC41_ADMINDepartments_DeleteTranslation - ตรวจสอบภาษาการลบข้อมูล และ pop up ที่แสดงขึ้นมา ของ UI21
    [Setup]    Reset Language To English
    Go To    ${DEPARTMENTS_URL}
    Wait Until Element Is Visible    xpath=//button[contains(@class, 'show_confirm')][1]    timeout=25s
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify Popup Language    Are you sure?    If you delete this, it will be gone forever    Deleted Successfully    # ปรับให้ตรงกับที่แสดงจริง
    Switch Language    th
    Go To    ${DEPARTMENTS_URL}
    Wait Until Element Is Visible    xpath=//button[contains(@class, 'show_confirm')][1]    timeout=25s
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify Popup Language    คุณแน่ใจหรือไม่?    หากคุณลบข้อมูลนี้ จะไม่สามารถกู้คืนได้    ลบสำเร็จ
    Switch Language    zh
    Go To    ${DEPARTMENTS_URL}
    Wait Until Element Is Visible    xpath=//button[contains(@class, 'show_confirm')][1]    timeout=25s
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify Popup Language    你确定吗？    如果删除，数据将永远消失。    删除成功