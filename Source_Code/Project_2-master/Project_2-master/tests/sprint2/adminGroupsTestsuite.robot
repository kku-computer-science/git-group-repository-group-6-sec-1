*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              chrome
${RESEARCH_GROUPS_URL}  http://127.0.0.1:8000/researchGroups
${CREATE_URL}           http://127.0.0.1:8000/researchGroups/create
${VALID_GROUP_ID}       3
${VIEW_URL}             http://127.0.0.1:8000/researchGroups/${VALID_GROUP_ID}
${EDIT_URL}             http://127.0.0.1:8000/researchGroups/${VALID_GROUP_ID}/edit
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
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'dropdown-menu')]    timeout=20s
    ${items}=    Get WebElements    xpath=//div[contains(@class, 'dropdown-menu')]//a
    FOR    ${item}    IN    @{items}
        ${text}=    Get Text    ${item}
        Log To Console    ตัวเลือกใน Dropdown: ${text}
    END
    ${english_present}=    Run Keyword And Return Status    Element Should Be Visible    xpath=//a[contains(., 'English')]
    ${thai_present}=       Run Keyword And Return Status    Element Should Be Visible    xpath=//a[contains(., 'ไทย')]
    ${chinese_present}=    Run Keyword And Return Status    Element Should Be Visible    xpath=//a[contains(., '中国')]
    Run Keyword If    not ${english_present}    Fail    English language option not found in dropdown
    Run Keyword If    not ${thai_present}       Fail    Thai language option not found in dropdown
    Run Keyword If    not ${chinese_present}    Fail    Chinese language option not found in dropdown
    Click Element    xpath=//a[contains(., 'English')]
    Wait Until Element Is Visible    xpath=//span[contains(@class, 'flag-icon-us')]    timeout=15s
    Wait Until Page Contains    Research Information Management System    timeout=20s
    Log To Console    Reset language to English

Switch Language
    [Arguments]    ${lang}
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=20s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    ${lang_text}=    Run Keyword If    '${lang}' == 'en'    Set Variable    English
    ...    ELSE IF    '${lang}' == 'th'    Set Variable    ไทย
    ...    ELSE IF    '${lang}' == 'zh'    Set Variable    中国
    ${lang_present}=    Run Keyword And Return Status    Element Should Be Visible    xpath=//a[contains(., '${lang_text}')]
    Run Keyword If    not ${lang_present}    Fail    Language ${lang_text} not found in dropdown
    Click Element    xpath=//a[contains(., '${lang_text}')]
    ${flag}=    Run Keyword If    '${lang}' == 'zh'    Set Variable    cn    ELSE    Set Variable    ${lang}
    Wait Until Element Is Visible    xpath=//span[contains(@class, 'flag-icon-${flag}')]    timeout=15s
    Run Keyword If    '${lang}' == 'en'    Wait Until Page Contains    Research Information Management System    timeout=20s
    Run Keyword If    '${lang}' == 'th'    Wait Until Page Contains    ระบบจัดการข้อมูลวิจัย    timeout=20s
    Run Keyword If    '${lang}' == 'zh'    Wait Until Page Contains    研究信息管理系统    timeout=20s
    Log To Console    Switched to language: ${lang}

Verify Page Language
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//h4[contains(@class, 'card-title')]    timeout=25s
    ${actual_text}=    Get Text    xpath=//h4[contains(@class, 'card-title')]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified page title: ${expected_text} (Actual: ${actual_text})

Verify Button Text
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//button[@type='submit']    timeout=20s
    ${actual_text}=    Get Text    xpath=//button[@type='submit']
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified button text: ${expected_text}

Verify New Group Button
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'btn btn-primary') and contains(@href, 'researchGroups/create')]    timeout=20s
    ${actual_text}=    Get Text    xpath=//a[contains(@class, 'btn btn-primary') and contains(@href, 'researchGroups/create')]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified new group button text: ${expected_text}

Verify Back Button
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'btn') and contains(@href, 'researchGroups')]    timeout=20s
    ${actual_text}=    Get Text    xpath=//a[contains(@class, 'btn') and contains(@href, 'researchGroups')]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified back button text: ${expected_text}

Verify Table Header
    [Arguments]    ${index}    ${expected_text}
    Wait Until Element Is Visible    xpath=//table//thead//th[${index}]    timeout=40s
    ${actual_text}=    Get Text    xpath=//table//thead//th[${index}]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified table header index ${index}: Expected "${expected_text}", Actual "${actual_text}"

Verify Popup Language
    [Arguments]    ${expected_title}    ${expected_text}    ${expected_success}
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-title')]    timeout=30s
    ${title}=    Get Text    xpath=//div[contains(@class, 'swal-title')]
    Should Contain    ${title}    ${expected_title}
    ${text}=    Get Text    xpath=//div[contains(@class, 'swal-text')]
    Should Contain    ${text}    ${expected_text}
    Click Element    xpath=//button[contains(., 'Cancel') or contains(., 'ยกเลิก') or contains(., '取消')]
    Reload Page
    Wait Until Element Is Visible    xpath=//h4[contains(@class, 'card-title')]    timeout=20s
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
TC01_ADMINResearchGroups - ตรวจสอบภาษาส่วนต่างๆ ของ UI13
    [Setup]    Reset Language To English
    Go To    ${RESEARCH_GROUPS_URL}
    Verify Page Language    Research Groups
    Verify New Group Button    ADD
    Switch Language    th
    Go To    ${RESEARCH_GROUPS_URL}
    Verify Page Language    กลุ่มวิจัย
    Verify New Group Button    เพิ่ม
    Switch Language    zh
    Go To    ${RESEARCH_GROUPS_URL}
    Verify Page Language    研究小组
    Verify New Group Button    添加

TC02_ADMINResearchGroups_Table - ตรวจสอบภาษาในตารางของ UI13
    [Setup]    Reset Language To English
    Go To    ${RESEARCH_GROUPS_URL}
    Verify Table Header    1    No.
    Verify Table Header    2    Group Name
    Verify Table Header    3    Head
    Verify Table Header    4    Member
    Verify Table Header    5    Action
    Switch Language    th
    Go To    ${RESEARCH_GROUPS_URL}
    Verify Table Header    1    ลำดับ
    Verify Table Header    2    ชื่อกลุ่ม
    Verify Table Header    3    หัวหน้า
    Verify Table Header    4    สมาชิก
    Verify Table Header    5    การกระทำ
    Switch Language    zh
    Go To    ${RESEARCH_GROUPS_URL}
    Verify Table Header    1    序号
    Verify Table Header    2    小组名称
    Verify Table Header    3    负责人
    Verify Table Header    4    成员
    Verify Table Header    5    操作

TC03_ADMINResearchGroup_Form - ตรวจสอบภาษาของฟอร์มเพิ่ม Research Group ของ UI13
    [Setup]    Reset Language To English
    Go To    ${CREATE_URL}
    Verify Page Language    Create Research Group
    Verify Back Button    Back
    Verify Button Text    Submit
    Switch Language    th
    Go To    ${CREATE_URL}
    Verify Page Language    สร้างกลุ่มวิจัย
    Verify Back Button    กลับ
    Verify Button Text    ยืนยัน
    Switch Language    zh
    Go To    ${CREATE_URL}
    Verify Page Language    创建研究小组
    Verify Back Button    返回
    Verify Button Text    提交

TC04_ADMINResearchGroup_View - ตรวจสอบภาษาข้อมูลในหน้าแสดงผลของ UI13
    [Setup]    Reset Language To English
    Go To    ${VIEW_URL}
    Verify Page Language    Research Groups
    Verify Back Button    Back
    Switch Language    th
    Go To    ${VIEW_URL}
    Verify Page Language    กลุ่มวิจัย
    Verify Back Button    กลับ
    Switch Language    zh
    Go To    ${VIEW_URL}
    Verify Page Language    研究小组
    Verify Back Button    返回

TC05_ADMINResearchGroup_Edit - ตรวจสอบภาษาของฟอร์มแก้ไขของ UI13
    [Setup]    Reset Language To English
    Go To    ${EDIT_URL}
    Verify Page Language    Edit Research Group
    Verify Back Button    Back
    Verify Button Text    Submit
    Switch Language    th
    Go To    ${EDIT_URL}
    Verify Page Language    แก้ไขข้อมูลกลุ่มวิจัย
    Verify Back Button    กลับ
    Verify Button Text    ยืนยัน
    Switch Language    zh
    Go To    ${EDIT_URL}
    Verify Page Language    编辑研究小组
    Verify Back Button    返回
    Verify Button Text    提交

TC06_ADMINResearchGroup_Delete - ตรวจสอบภาษาการลบข้อมูลและป๊อปอัพของ UI13
    [Setup]    Reset Language To English
    Go To    ${RESEARCH_GROUPS_URL}
    Wait Until Element Is Visible    xpath=//button[contains(@class, 'show_confirm')][1]    timeout=25s
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify Popup Language    Are you sure?    You will not be able to recover this file!    Deleted Successfully
    Switch Language    th
    Go To    ${RESEARCH_GROUPS_URL}
    Wait Until Element Is Visible    xpath=//button[contains(@class, 'show_confirm')][1]    timeout=25s
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify Popup Language    คุณแน่ใจหรือไม่?    หากคุณลบข้อมูลนี้ จะไม่สามารถกู้คืนได้    ลบสำเร็จ
    Switch Language    zh
    Go To    ${RESEARCH_GROUPS_URL}
    Wait Until Element Is Visible    xpath=//button[contains(@class, 'show_confirm')][1]    timeout=25s
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify Popup Language    你确定吗？    如果删除，数据将永远消失。    删除成功