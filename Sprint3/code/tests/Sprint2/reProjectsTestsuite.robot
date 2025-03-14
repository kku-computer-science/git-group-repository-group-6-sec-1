*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              chrome
${RESEARCH_URL}         https://cs6sec267.cpkkuhost.com/researchProjects
${CREATE_URL}           https://cs6sec267.cpkkuhost.com/researchProjects/create
${USERNAME}             punhor1@kku.ac.th
${PASSWORD}             123456789
${LOGIN_URL}            https://cs6sec267.cpkkuhost.com/login
${DASHBOARD_URL}        https://cs6sec267.cpkkuhost.com/dashboard

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
    Wait Until Page Contains Element    xpath=//a[@class='nav-link dropdown-toggle' and .//span[contains(@class, 'flag-icon')]]    15s

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
    Wait Until Page Contains Element    xpath=//a[@class='nav-link dropdown-toggle' and .//span[contains(@class, 'flag-icon')]]    15s
    Click Element    xpath=//a[@class='nav-link dropdown-toggle' and .//span[contains(@class, 'flag-icon')]]
    Click Element    xpath=//a[contains(@href, 'https://cs6sec267.cpkkuhost.com/lang/${lang}')]
    ${flag}=    Run Keyword If    '${lang}' == 'zh'    Set Variable    cn    ELSE    Set Variable    ${lang}
    Wait Until Page Contains Element    xpath=//span[contains(@class, 'flag-icon-${flag}')]    10s
    Log To Console    Switched to language: ${lang}

Verify Page Language
    [Arguments]    ${expected_text}
    Page Should Contain    ${expected_text}
    Log To Console    Verified text: ${expected_text}

Verify Table Data
    [Arguments]    ${row}    ${column}    ${expected_text}
    ${actual_text}=    Get Text    xpath=//table//tr[${row}]/td[${column}]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified table data at row ${row}, column ${column}: ${expected_text}

Logout
    # กดปุ่มหรือลิงค์สำหรับ Logout (ปรับ xpath ตามที่ระบบใช้งานจริง)
    Click Element    xpath=//a[contains(@href, '/logout')]
    Wait Until Page Contains    Login    10s
    Log To Console    Logged out successfully

Logout And Close Browser
    Logout
    Close Browser

*** Test Cases ***
TC01_REResearchProject_Form - ตรวจสอบภาษาส่วนต่างๆ
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาส่วนต่างๆ ในหน้า Research Projects ที่ /researchProjects
    Go To    ${RESEARCH_URL}
    Wait Until Page Contains    Research Projects    15s
    # ภาษาอังกฤษ
    Verify Page Language    Research Projects
    Verify Page Language    ADD
    Verify Page Language    No.
    Verify Page Language    Year
    Verify Page Language    Project Name
    Verify Page Language    Project Head
    Verify Page Language    Project Member
    Verify Page Language    Action
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-eye')]]  # ปุ่ม View
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-pencil')]]  # ปุ่ม Edit
    Page Should Contain Element    xpath=//button[contains(@class, 'btn') and .//i[contains(@class, 'mdi-delete')]]  # ปุ่ม Delete
    Verify Page Language    Are you sure?
    Verify Page Language    If you delete this, it will be gone forever.
    Verify Page Language    Deleted Successfully
    Verify Page Language    Search:

    Switch Language    th
    # ภาษาไทย
    Verify Page Language    โครงการวิจัย
    Verify Page Language    เพิ่ม
    Verify Page Language    ลำดับ
    Verify Page Language    ปี(ค.ศ.)
    Verify Page Language    ชื่อโครงการ
    Verify Page Language    หัวหน้าโครงการ
    Verify Page Language    สมาชิก
    Verify Page Language    การกระทำ
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-eye')]]  # ปุ่ม ดู
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-pencil')]]  # ปุ่ม แก้ไข
    Page Should Contain Element    xpath=//button[contains(@class, 'btn') and .//i[contains(@class, 'mdi-delete')]]  # ปุ่ม ลบ
    Verify Page Language    คุณแน่ใจหรือไม่?
    Verify Page Language    หากลบแล้ว ข้อมูลจะหายไปตลอดกาล
    Verify Page Language    ลบสำเร็จ
    Verify Page Language    ค้นหา:

    Switch Language    zh
    # ภาษาจีน
    Verify Page Language    研究项目
    Verify Page Language    添加
    Verify Page Language    序号
    Verify Page Language    年份
    Verify Page Language    项目名称
    Verify Page Language    项目负责人
    Verify Page Language    项目成员
    Verify Page Language    操作
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-eye')]]  # ปุ่ม 查看
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-pencil')]]  # ปุ่ม 编辑
    Page Should Contain Element    xpath=//button[contains(@class, 'btn') and .//i[contains(@class, 'mdi-delete')]]  # ปุ่ม 删除
    Verify Page Language    你确定吗？
    Verify Page Language    如果删除，数据将永远消失。
    Verify Page Language    删除成功
    Verify Page Language    搜索:

TC02__REResearchProject_Form - ตรวจสอบภาษาของฟอร์มเพิ่มข้อมูล
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาในฟอร์มเพิ่ม Research Project ที่ /researchProjects/create
    Go To    ${CREATE_URL}
    Wait Until Page Contains    Add Research Project    15s
    # ภาษาอังกฤษ
    Verify Page Language    Add Research Project
    Verify Page Language    Please fill in the details to edit the research project
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
    Verify Page Language    Project Member (Internal)
    Verify Page Language    Project Member (External)
    Verify Page Language    Title/Prefix
    Verify Page Language    First Name
    Verify Page Language    Last Name
    Verify Page Language    Submit
    Verify Page Language    Back
    Verify Page Language    Please select a fund
    Verify Page Language    Please specify status
    Verify Page Language    Select Member

    Switch Language    th
    # ภาษาไทย
    Verify Page Language    เพิ่มโครงการวิจัย
    Verify Page Language    กรอกข้อมูลแก้ไขรายละเอียดโครงการวิจัย
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
    Verify Page Language    สมาชิกโครงการ (ภายใน)
    Verify Page Language    สมาชิกโครงการ (ภายนอก)
    Verify Page Language    ตำแหน่งหรือคำนำหน้า
    Verify Page Language    ชื่อ
    Verify Page Language    นามสกุล
    Verify Page Language    Submit
    Verify Page Language    กลับ
    Verify Page Language    เลือกทุนวิจัย
    Verify Page Language    โปรดระบุสถานะ
    Verify Page Language    เลือกสมาชิก

    Switch Language    zh
    # ภาษาจีน
    Verify Page Language    添加研究项目
    Verify Page Language    请填写研究项目的详细信息以进行编辑
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
    Verify Page Language    项目成员 (内部)
    Verify Page Language    项目成员 (外部)
    Verify Page Language    职位或前缀
    Verify Page Language    名字
    Verify Page Language    姓氏
    Verify Page Language    提交
    Verify Page Language    返回
    Verify Page Language    请选择资金
    Verify Page Language    请指定状态
    Verify Page Language    选择成员

TC03_REResearchProject_Table - ตรวจสอบภาษาข้อมูลในตาราง
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาข้อมูลในตาราง Research Projects ที่ /researchProjects รวมถึง Project Head
    Go To    ${RESEARCH_URL}
    Wait Until Page Contains    Research Projects    15s
    # ภาษาอังกฤษ (ตรวจสอบหัวตารางและข้อมูล Project Head)
    Verify Page Language    Research Projects
    Verify Page Language    No.
    Verify Page Language    Year
    Verify Page Language    Project Name
    Verify Page Language    Project Head
    Verify Page Language    Project Member
    Verify Page Language    Action
    Verify Table Data    1    4    Pusadee

    Switch Language    th
    # ภาษาไทย (ตรวจสอบหัวตารางและข้อมูล Project Head)
    Verify Page Language    โครงการวิจัย
    Verify Page Language    ลำดับ
    Verify Page Language    ปี(ค.ศ.)
    Verify Page Language    ชื่อโครงการ
    Verify Page Language    หัวหน้าโครงการ
    Verify Page Language    สมาชิก
    Verify Page Language    การกระทำ
    Verify Table Data    1    4    พุธษดี

    Switch Language    zh
    # ภาษาจีน (ตรวจสอบหัวตารางและข้อมูล Project Head)
    Verify Page Language    研究项目
    Verify Page Language    序号
    Verify Page Language    年份
    Verify Page Language    项目名称
    Verify Page Language    项目负责人
    Verify Page Language    项目成员
    Verify Page Language    操作
    Verify Table Data    1    4    Pusadee

