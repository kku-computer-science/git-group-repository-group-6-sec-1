*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              Firefox
${RESEARCH_PROJECTS_URL}    http://127.0.0.1:8000/researchProjects
${CREATE_URL}           http://127.0.0.1:8000/researchProjects/create
${VALID_PROJECT_ID}     16    # อิงจาก URL ที่ให้มา
${VIEW_URL}             http://127.0.0.1:8000/researchProjects/${VALID_PROJECT_ID}
${EDIT_URL}             http://127.0.0.1:8000/researchProjects/${VALID_PROJECT_ID}/edit
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

Verify Placeholder
    [Arguments]    ${locator}    ${expected_value}
    ${actual_value}=    Get Element Attribute    ${locator}    placeholder
    Should Be Equal As Strings    ${actual_value}    ${expected_value}
    Log To Console    Verified placeholder of ${locator}: ${expected_value}

*** Test Cases ***
TC43_ADMINResearchProject - ตรวจสอบภาษาส่วนต่างๆ ของ UI12
    [Setup]    Reset Language To English
    Go To    ${RESEARCH_PROJECTS_URL}
    Verify Page Language    Research Projects
    Verify Page Language    ADD
    Verify Page Language    Project Name
    Verify Page Language    Action
    Switch Language    th
    Go To    ${RESEARCH_PROJECTS_URL}
    Verify Page Language    โครงการวิจัย
    Verify Page Language    เพิ่ม
    Verify Page Language    ชื่อโครงการ
    Verify Page Language    การกระทำ
    Switch Language    zh
    Go To    ${RESEARCH_PROJECTS_URL}
    Verify Page Language    研究项目
    Verify Page Language    添加
    Verify Page Language    项目名称
    Verify Page Language    操作

TC42_ADMINResearchProject_Table - ตรวจสอบภาษาในตารางของ UI12
    [Setup]    Reset Language To English
    Go To    ${RESEARCH_PROJECTS_URL}
    Verify Table Header    1    No.
    Verify Table Header    2    Year
    Verify Table Header    3    Project Name
    Verify Table Header    4    Project Head
    Verify Table Header    5    Project Member
    Verify Table Header    6    Action
    Switch Language    th
    Go To    ${RESEARCH_PROJECTS_URL}
    Verify Table Header    1    ลำดับ
    Verify Table Header    2    ปี(ค.ศ.)
    Verify Table Header    3    ชื่อโครงการ
    Verify Table Header    4    หัวหน้าโครงการ
    Verify Table Header    5    สมาชิก
    Verify Table Header    6    การกระทำ
    Switch Language    zh
    Go To    ${RESEARCH_PROJECTS_URL}
    Verify Table Header    1    序号
    Verify Table Header    2    年份
    Verify Table Header    3    项目名称
    Verify Table Header    4    项目负责人
    Verify Table Header    5    项目成员
    Verify Table Header    6    操作

TC40_ADMINResearchProject_Form - ตรวจสอบภาษาของฟอร์มเพิ่ม Research Project ของ UI12
    [Setup]    Reset Language To English
    Go To    ${CREATE_URL}
    # หัวข้อและคำอธิบาย
    Verify Page Language    Add Research Project
    Verify Page Language    Please fill in the details to edit the research project
    # ป้ายกำกับ (Labels)
    Verify Page Language    Project Name
    Verify Page Language    Project Start
    Verify Page Language    Project End
    Verify Page Language    Fund Source
    Verify Page Language    Year
    Verify Page Language    Budget
    Verify Page Language    Responsible Department
    Verify Page Language    Project Details
    Verify Page Language    Project Status
    Verify Page Language    Project Head
    Verify Page Language    Project Member (Internal)
    Verify Page Language    Project Member (External)
    Verify Page Language    Title/Prefix
    Verify Page Language    First Name
    Verify Page Language    Last Name
    # Placeholder
    Verify Placeholder    xpath=//input[@name='project_name']    Enter project name
    Verify Placeholder    xpath=//input[@name='title_name[]']    Enter title/prefix
    Verify Placeholder    xpath=//input[@name='fname[]']    Enter first name
    Verify Placeholder    xpath=//input[@name='lname[]']    Enter last name
    # Dropdown Options
    Verify Page Language    Please select a fund
    Verify Page Language    Please specify status
    Verify Page Language    Select Member
    # ปุ่ม
    Verify Page Language    Submit
    Verify Page Language    Back

    Switch Language    th
    Go To    ${CREATE_URL}
    # หัวข้อและคำอธิบาย
    Verify Page Language    เพิ่มโครงการวิจัย
    Verify Page Language    กรอกข้อมูลแก้ไขรายละเอียดโครงการวิจัย
    # ป้ายกำกับ (Labels)
    Verify Page Language    ชื่อโครงการ
    Verify Page Language    วันเริ่มต้นโครงการ
    Verify Page Language    วันสิ้นสุดโครงการ
    Verify Page Language    แหล่งทุนวิจัย
    Verify Page Language    ปี(ค.ศ.)
    Verify Page Language    จำนวนเงิน
    Verify Page Language    หน่วยงานที่รับผิดชอบ
    Verify Page Language    รายละเอียดโครงการ
    Verify Page Language    สถานะโครงการ
    Verify Page Language    ผู้รับผิดชอบโครงการ
    Verify Page Language    สมาชิกโครงการ (ภายใน)
    Verify Page Language    สมาชิกโครงการ (ภายนอก)
    Verify Page Language    ตำแหน่งหรือคำนำหน้า
    Verify Page Language    ชื่อ
    Verify Page Language    นามสกุล
    # Placeholder
    Verify Placeholder    xpath=//input[@name='project_name']    กรอกชื่อโครงการ
    Verify Placeholder    xpath=//input[@name='title_name[]']    กรอกตำแหน่งหรือคำนำหน้า
    Verify Placeholder    xpath=//input[@name='fname[]']    กรอกชื่อ
    Verify Placeholder    xpath=//input[@name='lname[]']    กรอกนามสกุล
    # Dropdown Options
    Verify Page Language    เลือกทุนวิจัย
    Verify Page Language    โปรดระบุสถานะ
    Verify Page Language    เลือกสมาชิก
    # ปุ่ม
    Verify Page Language    Submit
    Verify Page Language    กลับ

    Switch Language    zh
    Go To    ${CREATE_URL}
    # หัวข้อและคำอธิบาย
    Verify Page Language    添加研究项目
    Verify Page Language    请填写研究项目的详细信息以进行编辑
    # ป้ายกำกับ (Labels)
    Verify Page Language    项目名称
    Verify Page Language    项目开始日期
    Verify Page Language    项目结束日期
    Verify Page Language    研究资金来源
    Verify Page Language    年份
    Verify Page Language    预算
    Verify Page Language    负责部门
    Verify Page Language    项目详情
    Verify Page Language    项目状态
    Verify Page Language    项目负责人
    Verify Page Language    项目成员 (内部)
    Verify Page Language    项目成员 (外部)
    Verify Page Language    职位或前缀
    Verify Page Language    名字
    Verify Page Language    姓氏
    # Placeholder
    Verify Placeholder    xpath=//input[@name='project_name']    请输入项目名称
    Verify Placeholder    xpath=//input[@name='title_name[]']    请输入职位或前缀
    Verify Placeholder    xpath=//input[@name='fname[]']    请输入名字
    Verify Placeholder    xpath=//input[@name='lname[]']    请输入姓氏
    # Dropdown Options
    Verify Page Language    请选择资金
    Verify Page Language    请指定状态
    Verify Page Language    选择成员
    # ปุ่ม
    Verify Page Language    提交
    Verify Page Language    返回

TC41_ADMINResearchProject_View - ตรวจสอบภาษาข้อมูลในตารางของ UI12
    [Setup]    Reset Language To English
    Go To    ${VIEW_URL}
    # หัวข้อและคำอธิบาย
    Verify Page Language    Research project details information
    # ป้ายกำกับ (Labels)
    Verify Page Language    Project Name
    Verify Page Language    Project Start
    Verify Page Language    Project End
    Verify Page Language    Fund Source
    Verify Page Language    Budget
    Verify Page Language    Project Details
    Verify Page Language    Project Status
    Verify Page Language    Project Head
    Verify Page Language    Project Member
    # ปุ่ม
    Verify Page Language    Back

    Switch Language    th
    Go To    ${VIEW_URL}
    # หัวข้อและคำอธิบาย
    Verify Page Language    ข้อมูลรายละเอียดโครงการวิจัย
    # ป้ายกำกับ (Labels)
    Verify Page Language    ชื่อโครงการ
    Verify Page Language    วันเริ่มต้นโครงการ
    Verify Page Language    วันสิ้นสุดโครงการ
    Verify Page Language    แหล่งทุนวิจัย
    Verify Page Language    จำนวนเงิน
    Verify Page Language    รายละเอียดโครงการ
    Verify Page Language    สถานะโครงการ
    Verify Page Language    ผู้รับผิดชอบโครงการ
    Verify Page Language    สมาชิกโครงการ
    # ปุ่ม
    Verify Page Language    กลับ

    Switch Language    zh
    Go To    ${VIEW_URL}
    # หัวข้อและคำอธิบาย
    Verify Page Language    研究项目详细信息
    # ป้ายกำกับ (Labels)
    Verify Page Language    项目名称
    Verify Page Language    项目开始日期
    Verify Page Language    项目结束日期
    Verify Page Language    研究资金来源
    Verify Page Language    预算
    Verify Page Language    项目详情
    Verify Page Language    项目状态
    Verify Page Language    项目负责人
    Verify Page Language    项目成员
    # ปุ่ม
    Verify Page Language    返回

TC41_ADMINResearchProject_Edit - ตรวจสอบภาษาข้อมูลในตาราง ของ UI12
    [Setup]    Reset Language To English
    Go To    ${EDIT_URL}
    # หัวข้อและคำอธิบาย
    Verify Page Language    Edit Research Project
    Verify Page Language    Please fill in the details to edit the research project
    # ป้ายกำกับ (Labels)
    Verify Page Language    Project Name
    Verify Page Language    Project Start
    Verify Page Language    Project End
    Verify Page Language    Fund Source
    Verify Page Language    Year
    Verify Page Language    Budget
    Verify Page Language    Responsible Department
    Verify Page Language    Project Details
    Verify Page Language    Project Status
    Verify Page Language    Project Head
    Verify Page Language    Project Member
    Verify Page Language    Internal
    Verify Page Language    External
    # ปุ่ม
    Verify Page Language    Submit
    Verify Page Language    Back

    Switch Language    th
    Go To    ${EDIT_URL}
    # หัวข้อและคำอธิบาย
    Verify Page Language    แก้ไขโครงการวิจัย
    Verify Page Language    กรอกข้อมูลแก้ไขรายละเอียดโครงการวิจัย
    # ป้ายกำกับ (Labels)
    Verify Page Language    ชื่อโครงการ
    Verify Page Language    วันเริ่มต้นโครงการ
    Verify Page Language    วันสิ้นสุดโครงการ
    Verify Page Language    แหล่งทุนวิจัย
    Verify Page Language    ปี(ค.ศ.)
    Verify Page Language    จำนวนเงิน
    Verify Page Language    หน่วยงานที่รับผิดชอบ
    Verify Page Language    รายละเอียดโครงการ
    Verify Page Language    สถานะโครงการ
    Verify Page Language    ผู้รับผิดชอบโครงการ
    Verify Page Language    สมาชิกโครงการ
    Verify Page Language    ภายใน
    Verify Page Language    ภายนอก
    # ปุ่ม
    Verify Page Language    Submit
    Verify Page Language    กลับ

    Switch Language    zh
    Go To    ${EDIT_URL}
    # หัวข้อและคำอธิบาย
    Verify Page Language    编辑研究项目
    Verify Page Language    请填写研究项目的详细信息以进行编辑
    # ป้ายกำกับ (Labels)
    Verify Page Language    项目名称
    Verify Page Language    项目开始日期
    Verify Page Language    项目结束日期
    Verify Page Language    研究资金来源
    Verify Page Language    年份
    Verify Page Language    预算
    Verify Page Language    负责部门
    Verify Page Language    项目详情
    Verify Page Language    项目状态
    Verify Page Language    项目负责人
    Verify Page Language    项目成员
    Verify Page Language    内部
    Verify Page Language    外部
    # ปุ่ม
    Verify Page Language    提交
    Verify Page Language    返回

TC41_ADMINResearchGroup_Delete - ตรวจสอบภาษาการลบข้อมูล และ pop up ที่แสดงขึ้นมา ของ UI12
    [Setup]    Reset Language To English
    Go To    ${RESEARCH_PROJECTS_URL}
    Wait Until Page Contains    Research Projects    15s
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    ${popup_visible}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//h2[contains(@class, 'swal2-title')]
    Run Keyword If    ${popup_visible}    Verify Popup Language    Are you sure?    You will not be able to recover this file!    Deleted Successfully
    Switch Language    th
    Go To    ${RESEARCH_PROJECTS_URL}
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    ${popup_visible}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//h2[contains(@class, 'swal2-title')]
    Run Keyword If    ${popup_visible}    Verify Popup Language    คุณแน่ใจหรือไม่?    คุณจะไม่สามารถกู้คืนไฟล์นี้ได้!    ลบสำเร็จ
    Switch Language    zh
    Go To    ${RESEARCH_PROJECTS_URL}
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    ${popup_visible}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//h2[contains(@class, 'swal2-title')]
    Run Keyword If    ${popup_visible}    Verify Popup Language    你确定吗？    如果删除，数据将永远消失。    删除成功