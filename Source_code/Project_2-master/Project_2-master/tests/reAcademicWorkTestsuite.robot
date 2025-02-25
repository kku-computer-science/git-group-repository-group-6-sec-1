*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              Firefox
${PATENTS_URL}          http://127.0.0.1:8000/patents
${CREATE_URL}           http://127.0.0.1:8000/patents/create
${VALID_PATENT_ID}      1    # เปลี่ยนเป็น ID ที่มีอยู่ในฐานข้อมูลจริง
${VIEW_URL}             http://127.0.0.1:8000/patents/${VALID_PATENT_ID}
${EDIT_URL}             http://127.0.0.1:8000/patents/${VALID_PATENT_ID}/edit
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

Verify Popup Language
    [Arguments]    ${expected_title}    ${expected_text}    ${expected_success}
    Wait Until Page Contains Element    xpath=//div[contains(@class, 'swal-title')]    10s
    ${title}=    Get Text    xpath=//div[contains(@class, 'swal-title')]
    Should Contain    ${title}    ${expected_title}
    ${text}=     Get Text    xpath=//div[contains(@class, 'swal-text')]
    Should Contain    ${text}    ${expected_text}
    Click Element    xpath=//button[contains(@class, 'swal-button--confirm')]
    Wait Until Page Contains Element    xpath=//div[contains(@class, 'swal-title')]    10s
    ${success}=  Get Text    xpath=//div[contains(@class, 'swal-title')]
    Should Contain    ${success}    ${expected_success}

Logout And Close Browser
    # ไปหน้า Dashboard เพื่อให้เห็น Navbar
    Go To    ${DASHBOARD_URL}
    # รอและคลิกปุ่ม Logout
    Wait Until Page Contains Element    xpath=//a[@class='nav-link' and contains(@href, '/logout')]    15s
    Click Element    xpath=//a[@class='nav-link' and contains(@href, '/logout')]
    # รอให้ redirect ไปหน้า Login
    Wait Until Location Contains    ${LOGIN_URL}    15s
    Log To Console    Logged out successfully
    Close Browser

*** Test Cases ***
TC59_REAcademicWork_Delete - ตรวจสอบภาษาเมื่อกดปุ่ม Delete และ popup ต่างๆเมื่อลบ
    [Setup]    Reset Language To English
    Go To    ${PATENTS_URL}
    Wait Until Page Contains    Other Academic Works (Patents, Utility Models, Copyrights)    15s
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify Popup Language    Are you sure?    Once deleted, this information cannot be recovered.    Deleted successfully
    Switch Language    th
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify Popup Language    คุณแน่ใจหรือไม่?    หากลบแล้ว ข้อมูลจะหายไปตลอดกาล    ลบสำเร็จ
    Switch Language    zh
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify Popup Language    你确定吗？    删除后，数据将无法恢复。    删除成功

TC60_REAcademicWork - ตรวจสอบภาษาส่วนต่างๆ ของ UI17
    [Setup]    Reset Language To English
    Go To    ${PATENTS_URL}
    Verify Page Language    Other Academic Works (Patents, Utility Models, Copyrights)
    Verify Page Language    Add
    Verify Page Language    No.
    Verify Page Language    Name
    Verify Page Language    Type
    Verify Page Language    Registration Date
    Verify Page Language    Registration Number
    Verify Page Language    Creator
    Verify Page Language    Action
    Verify Page Language    Search:
    Switch Language    th
    Verify Page Language    ผลงานวิชาการอื่นๆ (สิทธิบัตร, อนุสิทธิบัตร, ลิขสิทธิ์)
    Verify Page Language    เพิ่ม
    Verify Page Language    ลำดับ
    Verify Page Language    ชื่อ
    Verify Page Language    ประเภท
    Verify Page Language    วันที่ได้รับลิขสิทธิ์
    Verify Page Language    เลขทะเบียน
    Verify Page Language    ผู้จัดทำ
    Verify Page Language    การกระทำ
    Verify Page Language    ค้นหา:
    Switch Language    zh
    Verify Page Language    其他学术作品 (专利, 实用新型, 版权)
    Verify Page Language    添加
    Verify Page Language    编号
    Verify Page Language    名称
    Verify Page Language    类别
    Verify Page Language    注册日期
    Verify Page Language    注册编号
    Verify Page Language    创建者
    Verify Page Language    操作
    Verify Page Language    搜索:

# TC61-TC65 คงเดิม (ย่อเพื่อความกระชับ)
TC61_REAcademicWork_Table - ตรวจสอบภาษาในตารางของ UI17
    [Setup]    Reset Language To English
    Go To    ${PATENTS_URL}
    Verify Table Header    1    No.
    Verify Table Header    2    Name
    Verify Table Header    3    Type
    Verify Table Header    4    Registration Date
    Verify Table Header    5    Registration Number
    Verify Table Header    6    Creator
    Verify Table Header    7    Action
    Switch Language    th
    Verify Table Header    1    ลำดับ
    Verify Table Header    2    ชื่อ
    Verify Table Header    3    ประเภท
    Verify Table Header    4    วันที่ได้รับลิขสิทธิ์
    Verify Table Header    5    เลขทะเบียน
    Verify Table Header    6    ผู้จัดทำ
    Verify Table Header    7    การกระทำ
    Switch Language    zh
    Verify Table Header    1    编号
    Verify Table Header    2    名称
    Verify Table Header    3    类别
    Verify Table Header    4    注册日期
    Verify Table Header    5    注册编号
    Verify Table Header    6    创建者
    Verify Table Header    7    操作

TC62_REAcademicWork_View - ตรวจสอบภาษาข้อมูลในหน้ารายละเอียดของ UI17
    [Setup]    Reset Language To English
    Go To    ${VIEW_URL}
    Verify Page Language    Other Academic Works (Patents, Utility Models, Copyrights)
    Verify Page Language    Name
    Verify Page Language    Type
    Verify Page Language    Registration Date
    Verify Page Language    Reg. No.:
    Verify Page Language    Creator
    Verify Page Language    Co-Creator
    Verify Page Language    Back
    Switch Language    th
    Verify Page Language    ผลงานวิชาการอื่นๆ (สิทธิบัตร, อนุสิทธิบัตร, ลิขสิทธิ์)
    Verify Page Language    ชื่อ
    Verify Page Language    ประเภท
    Verify Page Language    วันที่ได้รับลิขสิทธิ์
    Verify Page Language    เลขที่ :
    Verify Page Language    ผู้จัดทำ
    Verify Page Language    ผู้จัดทำ (ร่วม)
    Verify Page Language    กลับ
    Switch Language    zh
    Verify Page Language    其他学术作品 (专利, 实用新型, 版权)
    Verify Page Language    名称
    Verify Page Language    类别
    Verify Page Language    注册日期
    Verify Page Language    注册号:
    Verify Page Language    创建者
    Verify Page Language    共同创建者
    Verify Page Language    返回

TC63_REAcademicWork_Form - ตรวจสอบภาษาของฟอร์มเพิ่ม Patents ของ UI17
    [Setup]    Reset Language To English
    Go To    ${CREATE_URL}
    Verify Page Language    Add
    Verify Page Language    Enter details of patents, utility models, or copyrights
    Verify Page Language    Name
    Verify Page Language    Type
    Verify Page Language    Registration Date
    Verify Page Language    Registration Number
    Verify Page Language    Internal Authors
    Verify Page Language    External Authors
    Verify Page Language    Submit
    Verify Page Language    Cancel
    Switch Language    th
    Verify Page Language    เพิ่ม
    Verify Page Language    กรอกข้อมูลรายละเอียดงานสิทธิบัตร, อนุสิทธิบัตร, ลิขสิทธิ์
    Verify Page Language    ชื่อ
    Verify Page Language    ประเภท
    Verify Page Language    วันที่ได้รับลิขสิทธิ์
    Verify Page Language    เลขทะเบียน
    Verify Page Language    อาจารย์ในสาขา
    Verify Page Language    บุคลภายนอก
    Verify Page Language    บันทึก
    Verify Page Language    ยกเลิก
    Switch Language    zh
    Verify Page Language    添加
    Verify Page Language    输入专利、实用新型或版权的详细信息
    Verify Page Language    名称
    Verify Page Language    类别
    Verify Page Language    注册日期
    Verify Page Language    注册编号
    Verify Page Language    内部作者
    Verify Page Language    外部作者
    Verify Page Language    提交
    Verify Page Language    取消
