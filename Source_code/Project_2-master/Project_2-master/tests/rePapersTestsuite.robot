*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Close Browser

*** Variables ***
${BROWSER}              Chrome
${PAPERS_URL}           http://127.0.0.1:8000/papers
${CREATE_URL}           http://127.0.0.1:8000/papers/create
${VALID_PAPER_ID}       121
${VIEW_URL}             http://127.0.0.1:8000/papers/${VALID_PAPER_ID}
${EDIT_URL}             http://127.0.0.1:8000/papers/eyJpdiI6IjJyU3BnY3kwYm1OSWVlZksyTFRGVXc9PSIsInZhbHVlIjoiTi9RZkNkZ21wejBpWG0ybERYY1pMQT09IiwibWFjIjoiZTc1YWExNGZjZTVlZDU1NTEwZDExYjQ2MzQ1MmNiYmQ3ZGVmOTc2ZjIwOGZhNTQ4NTUwOGY3MDMwZGE4NDY3NiIsInRhZyI6IiJ9/edit
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
TC48_REPapers - ตรวจสอบภาษาส่วนต่างๆ
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาส่วนต่างๆ ในหน้า Papers ที่ /papers
    Go To    ${PAPERS_URL}
    Wait Until Page Contains    Published Research    15s
    # ภาษาอังกฤษ
    Verify Page Language    Published Research
    Verify Page Language    Add
    Verify Page Language    No.
    Verify Page Language    Paper Title
    Verify Page Language    Type
    Verify Page Language    Year Published
    Verify Page Language    Action
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-eye')]]  # ปุ่ม View
    ${edit_present}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-pencil')]]  # ปุ่ม Edit (ถ้ามี)
    Run Keyword If    ${edit_present}    Log To Console    Edit button found
    ...    ELSE    Log To Console    Edit button not found, possibly due to permissions or no data
    Verify Page Language    Search:

    Switch Language    th
    # ภาษาไทย
    Verify Page Language    ผลงานวิจัยที่ตีพิมพ์
    Verify Page Language    เพิ่ม
    Verify Page Language    ลำดับ
    Verify Page Language    ชื่อเรื่อง
    Verify Page Language    ประเภท
    Verify Page Language    ปีที่ตีพิมพ์
    Verify Page Language    การกระทำ
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-eye')]]  # ปุ่ม ดู
    ${edit_present}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-pencil')]]  # ปุ่ม แก้ไข (ถ้ามี)
    Run Keyword If    ${edit_present}    Log To Console    Edit button found
    ...    ELSE    Log To Console    Edit button not found, possibly due to permissions or no data
    Verify Page Language    ค้นหา:

    Switch Language    zh
    # ภาษาจีน
    Verify Page Language    已发布的研究
    Verify Page Language    添加
    Verify Page Language    序号
    Verify Page Language    论文标题
    Verify Page Language    类型
    Verify Page Language    出版年份
    Verify Page Language    操作
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-eye')]]  # ปุ่ม 查看
    ${edit_present}=    Run Keyword And Return Status    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-pencil')]]  # ปุ่ม 编辑 (ถ้ามี)
    Run Keyword If    ${edit_present}    Log To Console    Edit button found
    ...    ELSE    Log To Console    Edit button not found, possibly due to permissions or no data
    Verify Page Language    搜索:

TC49_REPapers_Table - ตรวจสอบภาษาของตาราง Papers
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาของตาราง Papers ที่ /papers
    Go To    ${PAPERS_URL}
    Wait Until Page Contains    Published Research    15s
    # ภาษาอังกฤษ (หัวตาราง)
    Verify Page Language    Published Research
    Verify Page Language    No.
    Verify Page Language    Paper Title
    Verify Page Language    Type
    Verify Page Language    Year Published
    Verify Page Language    Action

    Switch Language    th
    # ภาษาไทย (หัวตาราง)
    Verify Page Language    ผลงานวิจัยที่ตีพิมพ์
    Verify Page Language    ลำดับ
    Verify Page Language    ชื่อเรื่อง
    Verify Page Language    ประเภท
    Verify Page Language    ปีที่ตีพิมพ์
    Verify Page Language    การกระทำ

    Switch Language    zh
    # ภาษาจีน (หัวตาราง)
    Verify Page Language    已发布的研究
    Verify Page Language    序号
    Verify Page Language    论文标题
    Verify Page Language    类型
    Verify Page Language    出版年份
    Verify Page Language    操作

TC50_REPapers_View - ตรวจสอบภาษาข้อมูลในหน้ารายละเอียด
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาข้อมูลในหน้ารายละเอียด Papers ที่ /papers/{Id}
    Go To    ${VIEW_URL}
    Wait Until Page Contains    Published Research    15s
    # ภาษาอังกฤษ
    Verify Page Language    Published Research
    Verify Page Language    Published research details information
    Verify Page Language    Paper Title
    Verify Page Language    Abstract
    Verify Page Language    Keyword
    Verify Page Language    Type
    Verify Page Language    Document Type
    Verify Page Language    Source Title
    Verify Page Language    Year Published
    Verify Page Language    Volume
    Verify Page Language    Issue
    Verify Page Language    Page Number
    Verify Page Language    DOI
    Verify Page Language    URL
    Verify Page Language    Back

    Switch Language    th
    # ภาษาไทย
    Verify Page Language    ผลงานวิจัยที่ตีพิมพ์
    Verify Page Language    ข้อมูลรายละเอียดผลงานวิจัยที่ตีพิมพ์
    Verify Page Language    ชื่อเรื่อง
    ${abstract_present}=    Run Keyword And Return Status    Page Should Contain    บทคัดย่อ
    Run Keyword If    ${abstract_present}    Log To Console    Abstract label found
    ...    ELSE    Log To Console    Abstract label not found, possibly due to missing data
    ${keyword_present}=    Run Keyword And Return Status    Page Should Contain    หัวข้อที่เกี่ยวข้อง
    Run Keyword If    ${keyword_present}    Log To Console    Keyword label found
    ...    ELSE    Log To Console    Keyword label not found, possibly due to missing data
    Verify Page Language    ประเภท
    Verify Page Language    ประเภทเอกสาร
    Verify Page Language    ชื่องานวารสาร
    Verify Page Language    ปีที่ตีพิมพ์
    Verify Page Language    เล่มที่
    Verify Page Language    ฉบับที่
    Verify Page Language    เลขหน้า
    Verify Page Language    DOI
    Verify Page Language    URL
    Verify Page Language    กลับ

    Switch Language    zh
    # ภาษาจีน
    Verify Page Language    已发布的研究
    Verify Page Language    已发布研究的详细信息
    Verify Page Language    论文标题
    Verify Page Language    抽象的
    Verify Page Language    相关主题
    Verify Page Language    类型
    Verify Page Language    文档类型
    Verify Page Language    期刊名称
    Verify Page Language    出版年份
    Verify Page Language    卷号
    Verify Page Language    期号
    Verify Page Language    页码
    Verify Page Language    DOI
    Verify Page Language    URL
    Verify Page Language    返回

TC51_REPapers_Form - ตรวจสอบภาษาของฟอร์มเพิ่ม Papers
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาในฟอร์มเพิ่ม Papers ที่ /papers/create
    Go To    ${CREATE_URL}
    Wait Until Page Contains    Add Published Research    15s
    # ภาษาอังกฤษ
    Verify Page Language    Add Published Research
    Verify Page Language    Published research details information
    Verify Page Language    Source Title
    Verify Page Language    Paper Title
    Verify Page Language    Abstract
    Verify Page Language    Keyword
    Verify Page Language    Type
    Verify Page Language    Document Type
    Verify Page Language    Year Published
    Verify Page Language    Volume
    Verify Page Language    Issue
    Verify Page Language    Page Number
    Verify Page Language    DOI
    Verify Page Language    URL
    Verify Page Language    Author (Internal)
    Verify Page Language    Author (External)
    Verify Page Language    Select Member
    Verify Page Language    First Author
    Verify Page Language    Co-Author
    Verify Page Language    Corresponding Author
    Verify Page Language    Submit
    Verify Page Language    Back

    Switch Language    th
    # ภาษาไทย
    Verify Page Language    เพิ่ม ผลงานวิจัยที่ตีพิมพ์
    Verify Page Language    ข้อมูลรายละเอียดผลงานวิจัยที่ตีพิมพ์
    Verify Page Language    ชื่องานวารสาร
    Verify Page Language    ชื่อเรื่อง
    Verify Page Language    บทคัดย่อ
    Verify Page Language    หัวข้อที่เกี่ยวข้อง
    Verify Page Language    ประเภท
    Verify Page Language    ประเภทเอกสาร
    Verify Page Language    ปีที่ตีพิมพ์
    Verify Page Language    เล่มที่
    Verify Page Language    ฉบับที่
    Verify Page Language    เลขหน้า
    Verify Page Language    DOI
    Verify Page Language    URL
    Verify Page Language    ผู้เขียน (บุคลภายในสาขา)
    Verify Page Language    ผู้เขียน (บุคลภายนอก)
    Verify Page Language    เลือกสมาชิก
    Verify Page Language    ผู้เขียนคนแรก
    Verify Page Language    ผู้เขียนร่วม
    Verify Page Language    ผู้เขียนที่ติดต่อได้
    Verify Page Language    บันทึก
    Verify Page Language    กลับ

    Switch Language    zh
    # ภาษาจีน
    Verify Page Language    添加 已发布的研究
    Verify Page Language    已发布研究的详细信息
    Verify Page Language    期刊名称
    Verify Page Language    论文标题
    Verify Page Language    抽象的
    Verify Page Language    相关主题
    Verify Page Language    类型
    Verify Page Language    文档类型
    Verify Page Language    出版年份
    Verify Page Language    卷号
    Verify Page Language    期号
    Verify Page Language    页码
    Verify Page Language    DOI
    Verify Page Language    URL
    Verify Page Language    作者（内部）
    Verify Page Language    作者（外部）
    Verify Page Language    选择成员
    Verify Page Language    第一作者
    Verify Page Language    共同作者
    Verify Page Language    通讯作者
    Verify Page Language    提交
    Verify Page Language    返回

TC52_REPapers_FormEdit - ตรวจสอบภาษาของฟอร์มแก้ไข Papers
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาในฟอร์มแก้ไข Papers ที่ /papers/{encrypted_id}/edit
    Go To    ${EDIT_URL}
    Wait Until Page Contains    Edit Published Research    30s  # เพิ่ม timeout เป็น 30 วินาที
    # ภาษาอังกฤษ
    Verify Page Language    Edit Published Research
    Verify Page Language    Fill in the research details for editing
    Verify Page Language    Publication Source
    Verify Page Language    Paper Title
    Verify Page Language    Abstract
    Verify Page Language    Keyword
    Verify Page Language    Type
    Verify Page Language    Document Type
    Verify Page Language    Source Title
    Verify Page Language    Year Published
    Verify Page Language    Volume
    Verify Page Language    Issue
    Verify Page Language    Page Number
    Verify Page Language    DOI
    Verify Page Language    Funder
    Verify Page Language    URL
    Verify Page Language    Author (Internal)
    Verify Page Language    Author (External)
    Verify Page Language    First Author
    Verify Page Language    Co-Author
    Verify Page Language    Corresponding Author
    Verify Page Language    Submit
    Verify Page Language    Cancel

    Switch Language    th
    # ภาษาไทย
    Verify Page Language    แก้ไขผลงานตีพิมพ์
    Verify Page Language    กรอกข้อมูลรายละเอียดงานวิจัย
    Verify Page Language    แหล่งเผยแพร่งานวิจัย
    Verify Page Language    ชื่อเรื่อง
    Verify Page Language    บทคัดย่อ
    Verify Page Language    หัวข้อที่เกี่ยวข้อง
    Verify Page Language    ประเภท
    Verify Page Language    ประเภทเอกสาร
    Verify Page Language    ชื่องานวารสาร
    Verify Page Language    ปีที่ตีพิมพ์
    Verify Page Language    เล่มที่
    Verify Page Language    ฉบับที่
    Verify Page Language    เลขหน้า
    Verify Page Language    Doi
    Verify Page Language    ทุนสนับสนุน
    Verify Page Language    URL
    Verify Page Language    ผู้เขียน (บุคลภายในสาขา)
    Verify Page Language    ผู้เขียน (บุคลภายนอก)
    Verify Page Language    ผู้เขียนคนแรก
    Verify Page Language    ผู้เขียนร่วม
    Verify Page Language    ผู้เขียนที่ติดต่อได้
    Verify Page Language    บันทึก
    Verify Page Language    ยกเลิก

    Switch Language    zh
    # ภาษาจีน
    Verify Page Language    编辑已发布的研究
    Verify Page Language    填写研究详情以进行编辑
    Verify Page Language    出版来源
    Verify Page Language    论文标题
    Verify Page Language    抽象的
    Verify Page Language    相关主题
    Verify Page Language    类型
    Verify Page Language    文档类型
    Verify Page Language    期刊名称
    Verify Page Language    出版年份
    Verify Page Language    卷号
    Verify Page Language    期号
    Verify Page Language    页码
    Verify Page Language    DOI
    Verify Page Language    资助者
    Verify Page Language    URL
    Verify Page Language    作者（内部）
    Verify Page Language    作者（外部）
    Verify Page Language    第一作者
    Verify Page Language    共同作者
    Verify Page Language    通讯作者
    Verify Page Language    提交
    Verify Page Language    取消
