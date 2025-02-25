*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser    # เปลี่ยนจาก Close Browser เป็น Logout And Close Browser

*** Variables ***
${BROWSER}              Firefox
${BOOKS_URL}            http://127.0.0.1:8000/books
${CREATE_URL}           http://127.0.0.1:8000/books/create
${VALID_BOOK_ID}        1    # เปลี่ยนเป็น ID ที่มีอยู่ในฐานข้อมูลจริง (ยังคงไว้เพื่อ TC อื่น)
${VIEW_URL}             http://127.0.0.1:8000/books/15    # แก้ไขจากคำขอก่อนหน้า
${EDIT_URL}             http://127.0.0.1:8000/books/15/edit    # แก้ไขตามที่ระบุ
${USERNAME}             punhor1@kku.ac.th    # ปรับตามผู้ใช้จริง
${PASSWORD}             123456789            # ปรับตามรหัสผ่านจริง
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

Logout And Close Browser
    Go To    ${DASHBOARD_URL}
    Wait Until Page Contains Element    xpath=//a[@class='nav-link' and contains(@href, '/logout')]    15s
    Click Element    xpath=//a[@class='nav-link' and contains(@href, '/logout')]
    Wait Until Location Contains    ${LOGIN_URL}    15s
    Log To Console    Logged out successfully
    Close Browser

*** Test Cases ***
TC54_REBooks - ตรวจสอบภาษาส่วนต่างๆ ของ UI16
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาส่วนต่างๆ ในหน้า Books ที่ /books
    Go To    ${BOOKS_URL}
    Wait Until Page Contains    Books    15s
    # ภาษาอังกฤษ
    Verify Page Language    Books
    Verify Page Language    Add
    Verify Page Language    No.
    Verify Page Language    Book Name
    Verify Page Language    Year (AD)
    Verify Page Language    Publication
    Verify Page Language    Page
    Verify Page Language    Action
    Verify Page Language    Search:
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-eye')]]    # View button

    Switch Language    th
    # ภาษาไทย
    Verify Page Language    หนังสือ
    Verify Page Language    เพิ่ม
    Verify Page Language    ลำดับ
    Verify Page Language    ชื่อหนังสือ
    Verify Page Language    ปี (พ.ศ.)
    Verify Page Language    แหล่งเผยแพร่
    Verify Page Language    หน้า
    Verify Page Language    การกระทำ
    Verify Page Language    ค้นหา:
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-eye')]]    # ดู button

    Switch Language    zh
    # ภาษาจีน
    Verify Page Language    书籍
    Verify Page Language    添加
    Verify Page Language    序号
    Verify Page Language    书名
    Verify Page Language    年份 (公元)
    Verify Page Language    出版来源
    Verify Page Language    页码
    Verify Page Language    操作
    Verify Page Language    搜索:
    Page Should Contain Element    xpath=//a[contains(@class, 'btn') and .//i[contains(@class, 'mdi-eye')]]    # 查看 button

TC55_REBooks_Table - ตรวจสอบภาษาในตารางของ UI16
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาในตาราง Books ที่ /books
    Go To    ${BOOKS_URL}
    Wait Until Page Contains    Books    15s
    # ภาษาอังกฤษ (หัวตาราง)
    Verify Table Header    1    No.
    Verify Table Header    2    Book Name
    Verify Table Header    3    Year (AD)
    Verify Table Header    4    Publication
    Verify Table Header    5    Page
    Verify Table Header    6    Action

    Switch Language    th
    # ภาษาไทย (หัวตาราง)
    Verify Table Header    1    ลำดับ
    Verify Table Header    2    ชื่อหนังสือ
    Verify Table Header    3    ปี (พ.ศ.)
    Verify Table Header    4    แหล่งเผยแพร่
    Verify Table Header    5    หน้า
    Verify Table Header    6    การกระทำ

    Switch Language    zh
    # ภาษาจีน (หัวตาราง)
    Verify Table Header    1    序号
    Verify Table Header    2    书名
    Verify Table Header    3    年份 (公元)
    Verify Table Header    4    出版来源
    Verify Table Header    5    页码
    Verify Table Header    6    操作

TC56_REBooks_View - ตรวจสอบภาษาข้อมูลในหน้ารายละเอียดของ UI16
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาข้อมูลในหน้ารายละเอียด Books ที่ /books/15
    Go To    http://127.0.0.1:8000/books/15
    Wait Until Page Contains    Book Detail    15s
    # ภาษาอังกฤษ
    Verify Page Language    Book Detail
    Verify Page Language    Book detail information
    Verify Page Language    Book Name
    Verify Page Language    Year (AD)
    Verify Page Language    Publication
    Verify Page Language    Page
    Verify Page Language    Back

    Switch Language    th
    # ภาษาไทย
    Verify Page Language    รายละเอียดหนังสือ
    Verify Page Language    ข้อมูลรายละเอียดหนังสือ
    Verify Page Language    ชื่อหนังสือ
    Verify Page Language    ปี (พ.ศ.)
    Verify Page Language    แหล่งเผยแพร่
    Verify Page Language    หน้า
    Verify Page Language    กลับ

    Switch Language    zh
    # ภาษาจีน
    Verify Page Language    书籍详情
    Verify Page Language    书籍详细信息
    Verify Page Language    书名
    Verify Page Language    年份 (公元)
    Verify Page Language    出版来源
    Verify Page Language    页码
    Verify Page Language    返回

TC57_REBooks_Form - ตรวจสอบภาษาของฟอร์มเพิ่ม Books ของ UI16
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาในฟอร์มเพิ่ม Books ที่ /books/create
    Go To    ${CREATE_URL}
    Wait Until Page Contains    Add Books    15s
    # ภาษาอังกฤษ
    Verify Page Language    Add Books
    Verify Page Language    Book detail information
    Verify Page Language    Book Name
    Verify Page Language    Publication
    Verify Page Language    Year (AD)
    Verify Page Language    Page
    Verify Page Language    Submit
    Verify Page Language    Cancel

    Switch Language    th
    # ภาษาไทย
    Verify Page Language    เพิ่ม หนังสือ
    Verify Page Language    ข้อมูลรายละเอียดหนังสือ
    Verify Page Language    ชื่อหนังสือ
    Verify Page Language    แหล่งเผยแพร่
    Verify Page Language    ปี (พ.ศ.)
    Verify Page Language    หน้า
    Verify Page Language    Submit
    Verify Page Language    Cancel

    Switch Language    zh
    # ภาษาจีน
    Verify Page Language    添加 书籍
    Verify Page Language    书籍详细信息
    Verify Page Language    书名
    Verify Page Language    出版来源
    Verify Page Language    年份 (公元)
    Verify Page Language    页码
    Verify Page Language    提交
    Verify Page Language    取消

TC58_REBook_FormEdit - ตรวจสอบภาษาของฟอร์มแก้ไข Books ของ UI16
    [Setup]    Reset Language To English
    [Documentation]    ตรวจสอบภาษาในฟอร์มแก้ไข Books ที่ /books/15/edit
    Go To    http://127.0.0.1:8000/books/15/edit
    Wait Until Page Contains    Edit Book Detail    15s
    # ภาษาอังกฤษ
    Verify Page Language    Edit Book Detail
    Verify Page Language    Book detail information
    Verify Page Language    Book Name
    Verify Page Language    Publication
    Verify Page Language    Year (AD)
    Verify Page Language    Page
    Verify Page Language    Submit
    Verify Page Language    Cancel

    Switch Language    th
    # ภาษาไทย
    Verify Page Language    แก้ไขรายละเอียดหนังสือ
    Verify Page Language    ข้อมูลรายละเอียดหนังสือ
    Verify Page Language    ชื่อหนังสือ
    Verify Page Language    แหล่งเผยแพร่
    Verify Page Language    ปี (พ.ศ.)
    Verify Page Language    หน้า
    Verify Page Language    Submit
    Verify Page Language    Cancel

    Switch Language    zh
    # ภาษาจีน
    Verify Page Language    编辑书籍详情
    Verify Page Language    书籍详细信息
    Verify Page Language    书名
    Verify Page Language    出版来源
    Verify Page Language    年份 (公元)
    Verify Page Language    页码
    Verify Page Language    提交
    Verify Page Language    取消
