*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              Firefox
${FUNDS_URL}            http://127.0.0.1:8000/funds
${CREATE_URL}           http://127.0.0.1:8000/funds/create
${RESEARCH_URL}         http://127.0.0.1:8000/researchProjects
${VALID_FUND_ID}        2
${VIEW_URL}             http://127.0.0.1:8000/funds/${VALID_FUND_ID}
${USERNAME}             punhor1@kku.ac.th
${PASSWORD}             123456789
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
    Wait Until Page Contains Element    xpath=//a[@class='nav-link dropdown-toggle' and .//span[contains(@class, 'flag-icon')]]    15s

Reset Language To English
    Go To    ${DASHBOARD_URL}  # กลับไป dashboard เพื่อรีเซ็ต
    Wait Until Page Contains Element    xpath=//a[@class='nav-link dropdown-toggle' and .//span[contains(@class, 'flag-icon')]]    15s
    # ถ้าภาษาอังกฤษเป็น default และไม่มี /lang/en ให้คลิกที่ English ใน dropdown
    Click Element    xpath=//a[@class='nav-link dropdown-toggle' and .//span[contains(@class, 'flag-icon')]]
    ${english_present}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//a[@class='dropdown-item' and contains(., 'English')]
    Run Keyword If    ${english_present}    Click Element    xpath=//a[@class='dropdown-item' and contains(., 'English')]
    Wait Until Page Contains Element    xpath=//span[contains(@class, 'flag-icon-us')]    10s
    Log To Console    Reset language to English
    ${page_source}=    Get Source
    Log To Console    Page source after reset: ${page_source}

Switch Language
    [Arguments]    ${lang}
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

Logout
    # คลิกที่ปุ่มหรือลิงค์สำหรับ Logout (ปรับ xpath ตามระบบของคุณ)
    Click Element    xpath=//a[contains(@href, '/logout')]
    Wait Until Page Contains    Login    10s
    Log To Console    Logged out successfully

Logout And Close Browser
    Logout
    Close Browser

*** Test Cases ***
TC40_REFunds_Form - ตรวจสอบภาษาของฟอร์มเพิ่ม Funds
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาในฟอร์มเพิ่ม Funds ที่ /funds/create
    Go To    ${CREATE_URL}
    Wait Until Page Contains    Add Research Fund    15s
    Verify Page Language    Add Research Fund
    Verify Page Language    Please fill in the research fund details
    Verify Page Language    Fund Type
    Verify Page Language    Fund Level
    Verify Page Language    Fund Name
    Verify Page Language    Supporting Agency / Research Project

    Switch Language    th
    Verify Page Language    เพิ่มทุนวิจัย
    Verify Page Language    กรอกข้อมูลรายละเอียดทุนงานวิจัย
    Verify Page Language    ประเภททุน
    Verify Page Language    ระดับทุน
    Verify Page Language    ชื่อทุน
    Verify Page Language    หน่วยงานที่สนับสนุน / โครงการวิจัย

    Switch Language    zh
    Verify Page Language    添加研究资金
    Verify Page Language    请填写研究资金的详细信息
    Verify Page Language    资金类型
    Verify Page Language    资金等级
    Verify Page Language    资金名称
    Verify Page Language    支持机构 / 研究项目

TC41_REFunds_View - ตรวจสอบภาษาของข้อมูลในตาราง
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาของข้อมูลในหน้ารายละเอียด Funds ที่ /funds/{Id}
    Go To    ${VIEW_URL}
    Wait Until Page Contains    Research Funds    15s
    Verify Page Language    Research Funds
    Verify Page Language    Fund Name
    Verify Page Language    Year
    Verify Page Language    Fund Details
    Verify Page Language    Fund Type
    Verify Page Language    Fund Level
    Verify Page Language    Supporting Agency / Research Project

    Switch Language    th
    Verify Page Language    ทุนวิจัย
    Verify Page Language    ชื่อทุน
    Verify Page Language    ปี
    Verify Page Language    รายละเอียดทุน
    Verify Page Language    ประเภททุน
    Verify Page Language    ระดับทุน
    Verify Page Language    หน่วยงานที่สนับสนุน / โครงการวิจัย

    Switch Language    zh
    Verify Page Language    研究资金
    Verify Page Language    资金名称
    Verify Page Language    年份
    Verify Page Language    资金详情
    Verify Page Language    资金类型
    Verify Page Language    资金等级
    Verify Page Language    支持机构 / 研究项目

TC42_REFunds_Table - ตรวจสอบภาษาในตาราง Research Projects
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาในหน้ารายการ Research Projects ที่ /researchProjects
    Go To    ${RESEARCH_URL}
    Wait Until Page Contains    Research Project    15s
    Verify Page Language    Research Project
    Verify Page Language    No.

    Switch Language    th
    Verify Page Language    โครงการวิจัย
    Verify Page Language    ลำดับ

    Switch Language    zh
    Verify Page Language    研究项目
    Verify Page Language    序号

TC43_REFunds - ตรวจสอบภาษาส่วนต่างๆ ของ Funds รวมถึง Fund Type
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาในหน้ารายการ Funds ที่ /funds รวมถึง fund_type
    Go To    ${FUNDS_URL}
    Wait Until Page Contains    Research Funds    15s
    Verify Page Language    Research Funds
    Verify Page Language    ADD
    Verify Page Language    No.
    Verify Page Language    Fund Name
    Verify Page Language    Fund Type
    Verify Page Language    Fund Level
    Verify Page Language    Action
    # ตรวจสอบ fund_type ในตาราง (สมมติแถวแรก)
    Page Should Contain Element    xpath=//table//tr[1]/td[3][contains(., 'Internal Fund')]
    Log To Console    Verified fund_type: Internal Fund

    Switch Language    th
    Verify Page Language    ทุนวิจัย
    Verify Page Language    เพิ่ม
    Verify Page Language    ลำดับ
    Verify Page Language    ชื่อทุน
    Verify Page Language    ประเภททุน
    Verify Page Language    ระดับทุน
    Verify Page Language    การกระทำ
    # ตรวจสอบ fund_type ในตาราง (สมมติแถวแรก)
    Page Should Contain Element    xpath=//table//tr[1]/td[3][contains(., 'ทุนภายใน')]
    Log To Console    Verified fund_type: ทุนภายใน

    Switch Language    zh
    Verify Page Language    研究资金
    Verify Page Language    添加
    Verify Page Language    序号
    Verify Page Language    资金名称
    Verify Page Language    资金类型
    Verify Page Language    资金等级
    Verify Page Language    操作
    # ตรวจสอบ fund_type ในตาราง (สมมติแถวแรก)
    Page Should Contain Element    xpath=//table//tr[1]/td[3][contains(., '内部资金')]
    Log To Console    Verified fund_type: 内部资金
