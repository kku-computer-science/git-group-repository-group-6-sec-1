*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Close Browser

*** Variables ***
${BROWSER}              Chrome
${RESEARCH_GROUPS_URL}  http://127.0.0.1:8000/researchGroups
${CREATE_URL}           http://127.0.0.1:8000/researchGroups/create
${VALID_GROUP_ID}       3
${VIEW_URL}             http://127.0.0.1:8000/researchGroups/${VALID_GROUP_ID}
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
    Click Element    xpath=//a[contains(@href, 'http://127.0.0.1:8000/lang/${lang}')]
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

*** Test Cases ***
TC47_REReseachGroup_Form - ตรวจสอบภาษาของฟอร์มเพิ่ม Research Group
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาในฟอร์มเพิ่ม Research Group ที่ /researchGroups/create
    Go To    ${CREATE_URL}
    Wait Until Page Contains    Create Research Group    15s
    # ภาษาอังกฤษ
    Verify Page Language    Create Research Group
    Verify Page Language    Please fill in the details to edit the research group
    Verify Page Language    Group Name (Thai)
    Verify Page Language    Group Name (English)
    Verify Page Language    Group Description (Thai)
    Verify Page Language    Group Description (English)
    Verify Page Language    Group Detail (Thai)
    Verify Page Language    Group Detail (English)
    Verify Page Language    Group Image
    Verify Page Language    Group Head
    Verify Page Language    Group Member (Internal)
    Verify Page Language    Group Member (External)
    Verify Page Language    Title/Prefix
    Verify Page Language    First Name
    Verify Page Language    Last Name
    Verify Page Language    Submit
    Verify Page Language    Back
    Verify Page Language    Select Member

    Switch Language    th
    # ภาษาไทย
    Verify Page Language    สร้างกลุ่มวิจัย
    Verify Page Language    กรอกข้อมูลแก้ไขรายละเอียดกลุ่มวิจัย
    Verify Page Language    ชื่อกลุ่มวิจัย (ภาษาไทย)
    Verify Page Language    ชื่อกลุ่มวิจัย (English)
    Verify Page Language    คำอธิบายกลุ่มวิจัย (ภาษาไทย)
    Verify Page Language    คำอธิบายกลุ่มวิจัย (English)
    Verify Page Language    รายละเอียดกลุ่มวิจัย (ภาษาไทย)
    Verify Page Language    รายละเอียดกลุ่มวิจัย (English)
    Verify Page Language    รูปภาพกลุ่มวิจัย
    Verify Page Language    หัวหน้ากลุ่มวิจัย
    Verify Page Language    สมาชิกกลุ่มวิจัย (ภายใน)
    Verify Page Language    สมาชิกกลุ่มวิจัย (ภายนอก)
    Verify Page Language    ตำแหน่งหรือคำนำหน้า
    Verify Page Language    ชื่อ
    Verify Page Language    นามสกุล
    Verify Page Language    Submit
    Verify Page Language    กลับ
    Verify Page Language    เลือกสมาชิก

    Switch Language    zh
    # ภาษาจีน
    Verify Page Language    创建研究小组
    Verify Page Language    请填写研究小组的详细信息以进行编辑
    Verify Page Language    小组名称 (泰语)
    Verify Page Language    小组名称 (英文)
    Verify Page Language    小组描述 (泰语)
    Verify Page Language    小组描述 (英文)
    Verify Page Language    小组详情 (泰语)
    Verify Page Language    小组详情 (英文)
    Verify Page Language    小组图片
    Verify Page Language    小组负责人
    Verify Page Language    小组成员 (内部)
    Verify Page Language    小组成员 (外部)
    Verify Page Language    职位或前缀
    Verify Page Language    名字
    Verify Page Language    姓氏
    Verify Page Language    提交
    Verify Page Language    返回
    Verify Page Language    选择成员

TC46_REReseachGroup_View - ตรวจสอบภาษาข้อมูลในหน้ารายละเอียด
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาข้อมูลในหน้ารายละเอียด Research Group ที่ /researchGroups/3
    Go To    ${VIEW_URL}
    Wait Until Page Contains    Research Groups    15s
    # ภาษาอังกฤษ
    Verify Page Language    Research Groups
    Verify Page Language    Research group details information
    Verify Page Language    Group Name (Thai)
    Verify Page Language    Group Name (English)
    Verify Page Language    Group Description (Thai)
    Verify Page Language    Group Description (English)
    Verify Page Language    Group Detail (Thai)
    Verify Page Language    Group Detail (English)
    Verify Page Language    Group Image
    Verify Page Language    Group Head
    Verify Page Language    Group Member (Internal)
    Verify Page Language    Group Member (External)
    Verify Page Language    Back

    Switch Language    th
    # ภาษาไทย
    Verify Page Language    กลุ่มวิจัย
    Verify Page Language    ข้อมูลรายละเอียดกลุ่มวิจัย
    Verify Page Language    ชื่อกลุ่มวิจัย (ภาษาไทย)
    Verify Page Language    ชื่อกลุ่มวิจัย (English)
    Verify Page Language    คำอธิบายกลุ่มวิจัย (ภาษาไทย)
    Verify Page Language    คำอธิบายกลุ่มวิจัย (English)
    Verify Page Language    รายละเอียดกลุ่มวิจัย (ภาษาไทย)
    Verify Page Language    รายละเอียดกลุ่มวิจัย (English)
    Verify Page Language    รูปภาพกลุ่มวิจัย
    Verify Page Language    หัวหน้ากลุ่มวิจัย
    Verify Page Language    สมาชิกกลุ่มวิจัย (ภายใน)
    Verify Page Language    สมาชิกกลุ่มวิจัย (ภายนอก)
    Verify Page Language    กลับ

    Switch Language    zh
    # ภาษาจีน
    Verify Page Language    研究小组
    Verify Page Language    研究小组详细信息
    Verify Page Language    小组名称 (泰语)
    Verify Page Language    小组名称 (英文)
    Verify Page Language    小组描述 (泰语)
    Verify Page Language    小组描述 (英文)
    Verify Page Language    小组详情 (泰语)
    Verify Page Language    小组详情 (英文)
    Verify Page Language    小组图片
    Verify Page Language    小组负责人
    Verify Page Language    小组成员 (内部)
    Verify Page Language    小组成员 (外部)
    Verify Page Language    返回

TC45_REReseachGroup_Table - ตรวจสอบภาษาของตาราง Research Groups
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาของตาราง Research Groups ที่ /researchGroups
    Go To    ${RESEARCH_GROUPS_URL}
    Wait Until Page Contains    Research Groups    15s
    # ภาษาอังกฤษ (หัวตาราง)
    Verify Page Language    Research Groups
    Verify Page Language    No.
    Verify Page Language    Group Name
    Verify Page Language    Head
    Verify Page Language    Member
    Verify Page Language    Action

    Switch Language    th
    # ภาษาไทย (หัวตาราง)
    Verify Page Language    กลุ่มวิจัย
    Verify Page Language    ลำดับ
    Verify Page Language    ชื่อกลุ่ม
    Verify Page Language    หัวหน้า
    Verify Page Language    สมาชิก
    Verify Page Language    การกระทำ

    Switch Language    zh
    # ภาษาจีน (หัวตาราง)
    Verify Page Language    研究小组
    Verify Page Language    序号
    Verify Page Language    小组名称
    Verify Page Language    负责人
    Verify Page Language    成员
    Verify Page Language    操作

TC44_REReseachGroup - ตรวจสอบภาษาส่วนต่างๆ
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาส่วนต่างๆ ในหน้า Research Groups ที่ /researchGroups
    Go To    ${RESEARCH_GROUPS_URL}
    Wait Until Page Contains    Research Groups    15s
    # ภาษาอังกฤษ
    Verify Page Language    Research Groups
    Verify Page Language    ADD
    Verify Page Language    No.
    Verify Page Language    Group Name
    Verify Page Language    Head
    Verify Page Language    Member
    Verify Page Language    Action
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-eye')]]  # ปุ่ม View
    ${edit_present}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-pencil')]]  # ปุ่ม Edit (ถ้ามี)
    Run Keyword If    ${edit_present}    Log To Console    Edit button found
    ...    ELSE    Log To Console    Edit button not found, possibly due to permissions or no data
    ${delete_present}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//button[contains(@class, 'btn') and .//i[contains(@class, 'mdi-delete')]]  # ปุ่ม Delete (ถ้ามี)
    Run Keyword If    ${delete_present}    Log To Console    Delete button found
    ...    ELSE    Log To Console    Delete button not found, possibly due to permissions or no data
    ${row_count}=    Get Element Count    xpath=//table//tr
    Log To Console    Number of rows in table: ${row_count}
    Verify Page Language    Are you sure?
    Verify Page Language    If you delete this, it will be gone forever.
    Verify Page Language    Deleted Successfully
    Verify Page Language    Search:

    Switch Language    th
    # ภาษาไทย
    Verify Page Language    กลุ่มวิจัย
    Verify Page Language    เพิ่ม
    Verify Page Language    ลำดับ
    Verify Page Language    ชื่อกลุ่ม
    Verify Page Language    หัวหน้า
    Verify Page Language    สมาชิก
    Verify Page Language    การกระทำ
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-eye')]]  # ปุ่ม ดู
    ${edit_present}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-pencil')]]  # ปุ่ม แก้ไข (ถ้ามี)
    Run Keyword If    ${edit_present}    Log To Console    Edit button found
    ...    ELSE    Log To Console    Edit button not found, possibly due to permissions or no data
    ${delete_present}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//button[contains(@class, 'btn') and .//i[contains(@class, 'mdi-delete')]]  # ปุ่ม ลบ (ถ้ามี)
    Run Keyword If    ${delete_present}    Log To Console    Delete button found
    ...    ELSE    Log To Console    Delete button not found, possibly due to permissions or no data
    ${row_count}=    Get Element Count    xpath=//table//tr
    Log To Console    Number of rows in table: ${row_count}
    Verify Page Language    คุณแน่ใจหรือไม่?
    Verify Page Language    หากลบแล้ว ข้อมูลจะหายไปตลอดกาล
    Verify Page Language    ลบสำเร็จ
    Verify Page Language    ค้นหา:

    Switch Language    zh
    # ภาษาจีน
    Verify Page Language    研究小组
    Verify Page Language    添加
    Verify Page Language    序号
    Verify Page Language    小组名称
    Verify Page Language    负责人
    Verify Page Language    成员
    Verify Page Language    操作
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-eye')]]  # ปุ่ม 查看
    ${edit_present}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-pencil')]]  # ปุ่ม 编辑 (ถ้ามี)
    Run Keyword If    ${edit_present}    Log To Console    Edit button found
    ...    ELSE    Log To Console    Edit button not found, possibly due to permissions or no data
    ${delete_present}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//button[contains(@class, 'btn') and .//i[contains(@class, 'mdi-delete')]]  # ปุ่ม 删除 (ถ้ามี)
    Run Keyword If    ${delete_present}    Log To Console    Delete button found
    ...    ELSE    Log To Console    Delete button not found, possibly due to permissions or no data
    ${row_count}=    Get Element Count    xpath=//table//tr
    Log To Console    Number of rows in table: ${row_count}
    Verify Page Language    你确定吗？
    Verify Page Language    如果删除，数据将永远消失。
    Verify Page Language    删除成功
    Verify Page Language    搜索:
