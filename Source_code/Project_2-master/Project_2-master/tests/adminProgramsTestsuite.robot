*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              Firefox
${PROGRAMS_URL}         http://127.0.0.1:8000/programs
${CREATE_URL}           http://127.0.0.1:8000/programs/create
${VALID_PROGRAM_ID}     3    # เปลี่ยนเป็น ID ที่มีอยู่ในฐานข้อมูลจริง
${EDIT_URL}             http://127.0.0.1:8000/programs/${VALID_PROGRAM_ID}/edit
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
    Input Text    id=username    ${USERNAME}
    Input Text    id=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit']
    Wait Until Location Contains    ${DASHBOARD_URL}    15s
    Log To Console    Login successful, redirected to: ${DASHBOARD_URL}

Reset Language To English
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=15s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    Sleep    2s    # รอให้ Dropdown โหลด
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'dropdown-menu')]    timeout=10s
    ${dropdown_items}=    Get WebElements    xpath=//div[contains(@class, 'dropdown-menu')]//a
    FOR    ${item}    IN    @{dropdown_items}
        ${text}=    Get Text    ${item}
        Log To Console    Dropdown item: ${text}
        Run Keyword If    '${text}' == 'English' or '${text}' == 'EN' or '${text}' == 'en'    Click Element    ${item}
    END
    Sleep    2s    # รอให้หน้าโหลดหลังเปลี่ยนภาษา
    Wait Until Page Contains Element    xpath=//span[contains(@class, 'flag-icon-us')]    10s
    Log To Console    Reset language to English

Switch Language
    [Arguments]    ${lang}
    ${lang_text}=    Set Variable If    '${lang}' == 'en'    English    '${lang}' == 'th'    ไทย    '${lang}' == 'zh'    中国
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=15s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    Sleep    2s    # รอให้ Dropdown โหลด
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'dropdown-menu')]    timeout=10s
    ${dropdown_items}=    Get WebElements    xpath=//div[contains(@class, 'dropdown-menu')]//a
    FOR    ${item}    IN    @{dropdown_items}
        ${text}=    Get Text    ${item}
        Log To Console    Dropdown item: ${text}
        Run Keyword If    '${text}' == '${lang_text}'    Click Element    ${item}
    END
    Sleep    2s    # รอให้หน้าโหลดหลังเปลี่ยนภาษา
    ${flag}=    Run Keyword If    '${lang}' == 'zh'    Set Variable    cn    ELSE    Set Variable    ${lang}
    Wait Until Page Contains Element    xpath=//span[contains(@class, 'flag-icon-${flag}')]    10s
    Log To Console    Switched to language: ${lang}

Verify Page Language
    [Arguments]    ${expected_text}
    Wait Until Page Contains    ${expected_text}    15s
    Log To Console    Verified page text: ${expected_text}

Verify ModalHeader
    [Arguments]    ${expected_text}
    Wait Until Element Contains    xpath=//div[@id='crud-modal']//h4[@id='programCrudModal']    ${expected_text}    15s
    ${actual_text}=    Get Text    xpath=//div[@id='crud-modal']//h4[@id='programCrudModal']
    Log To Console    Actual modal header text: ${actual_text}
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified modal header: ${expected_text}

Verify Table Header
    [Arguments]    ${column}    ${expected_text}
    Wait Until Element Is Visible    xpath=//table//thead//th[${column}]    15s
    ${actual_text}=    Get Text    xpath=//table//thead//th[${column}]
    Log To Console    Actual table header column ${column} text: ${actual_text}
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified table header column ${column}: ${expected_text}

Open AddModal
    Wait Until Page Contains Element    xpath=//a[@id='new-program']    15s
    Click Element    xpath=//a[@id='new-program']
    Sleep    3s    # รอให้ JavaScript โหลด Modal Header
    Wait Until Page Contains Element    xpath=//div[@id='crud-modal']//h4[@id='programCrudModal']    15s
    Log To Console    Add modal opened

Verify FormLabel
    [Arguments]    ${label_xpath}    ${expected_text}
    Wait Until Element Is Visible    ${label_xpath}    15s
    ${actual_text}=    Get Text    ${label_xpath}
    Log To Console    Actual label text: ${actual_text}
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified label: ${expected_text}

Verify PlaceholderText
    [Arguments]    ${input_xpath}    ${expected_placeholder}
    Wait Until Element Is Visible    ${input_xpath}    15s
    ${actual_placeholder}=    Get Element Attribute    ${input_xpath}    placeholder
    Log To Console    Actual placeholder text: ${actual_placeholder}
    Should Contain    ${actual_placeholder}    ${expected_placeholder}
    Log To Console    Verified placeholder: ${expected_placeholder}

Verify ButtonText
    [Arguments]    ${button_xpath}    ${expected_text}
    Wait Until Element Is Visible    ${button_xpath}    15s
    ${actual_text}=    Get Text    ${button_xpath}
    Log To Console    Actual button text: ${actual_text}
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified button: ${expected_text}

Open EditModal
    Wait Until Page Contains Element    xpath=//a[@id='edit-program'][1]    15s
    Click Element    xpath=//a[@id='edit-program'][1]
    Sleep    3s    # รอให้ JavaScript โหลด Modal Header
    Wait Until Page Contains Element    xpath=//div[@id='crud-modal']//h4[@id='programCrudModal']    15s
    Log To Console    Edit modal opened

Close Modal
    Click Element    xpath=//div[@id='crud-modal']//a[contains(text(), 'Cancel')]
    Wait Until Page Contains Element    xpath=//div[contains(@class, 'card-body')]    15s
    Log To Console    Modal closed

Verify PopupLanguage
    [Arguments]    ${expected_title}    ${expected_text}    ${expected_success}
    Wait Until Page Contains Element    xpath=//div[contains(@class, 'swal-title')]    15s
    ${title}=    Get Text    xpath=//div[contains(@class, 'swal-title')]
    Log To Console    Actual popup title: ${title}
    Should Contain    ${title}    ${expected_title}
    ${text}=    Get Text    xpath=//div[contains(@class, 'swal-text')]
    Log To Console    Actual popup text: ${text}
    Should Contain    ${text}    ${expected_text}
    Click Element    xpath=//button[contains(@class, 'swal-button--confirm')]
    Sleep    3s    # รอให้หน้าโหลดหลังลบ
    Wait Until Page Contains Element    xpath=//div[contains(@class, 'card-body')]    15s
    Log To Console    Verified popup: ${expected_title}, ${expected_text}, ${expected_success}

Logout And Close Browser
    Go To    ${DASHBOARD_URL}
    Click Element    xpath=//a[contains(@href, '/logout')]
    Wait Until Location Contains    ${LOGIN_URL}    15s
    Log To Console    Logged out successfully
    Close Browser

*** Test Cases ***
TC43_ADMINPrograms - ตรวจสอบภาษาส่วนต่างๆ ของ UI22 ที่ http://127.0.0.1:8000/programs
    [Setup]    Reset Language To English
    Go To    ${PROGRAMS_URL}
    Verify Page Language    Programs
    Verify Page Language    Add Program
    Switch Language    th
    Go To    ${PROGRAMS_URL}
    Verify Page Language    หลักสูตร
    Verify Page Language    เพิ่มหลักสูตร
    Switch Language    zh
    Go To    ${PROGRAMS_URL}
    Verify Page Language    课程
    Verify Page Language    添加课程

TC42_ADMINPrograms_TableTranslation - ตรวจสอบภาษาในตารางของ UI22 ที่ http://127.0.0.1:8000/programs
    [Setup]    Reset Language To English
    Go To    ${PROGRAMS_URL}
    Verify Table Header    1    ID
    Verify Table Header    2    Program Name (TH)
    Verify Table Header    3    Degree
    Verify Table Header    4    Action
    Switch Language    th
    Go To    ${PROGRAMS_URL}
    Verify Table Header    1    รหัส
    Verify Table Header    2    ชื่อหลักสูตร (TH)
    Verify Table Header    3    ระดับการศึกษา
    Verify Table Header    4    การกระทำ
    Switch Language    zh
    Go To    ${PROGRAMS_URL}
    Verify Table Header    1    编号
    Verify Table Header    2    课程名称 (泰语)
    Verify Table Header    3    学历
    Verify Table Header    4    操作

TC40_ADMINPrograms_FormTranslation - ตรวจสอบภาษาของฟอร์มเพิ่ม Programs ของ UI22 ที่ http://127.0.0.1:8000/programs
    [Setup]    Reset Language To English
    Go To    ${PROGRAMS_URL}
    Open AddModal
    Verify ModalHeader    Add Program
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'Degree')]    Degree
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'Department')]    Department
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'Program Name (TH)')]    Program Name (TH)
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'Program Name (EN)')]    Program Name (EN)
    Verify PlaceholderText    xpath=//input[@id='program_name_th']    Enter program name in Thai
    Verify PlaceholderText    xpath=//input[@id='program_name_en']    Enter program name in English
    Verify ButtonText    xpath=//button[@id='btn-save']    Submit
    Verify ButtonText    xpath=//div[@id='crud-modal']//a[contains(text(), 'Cancel')]    Cancel
    Close Modal
    Switch Language    th
    Go To    ${PROGRAMS_URL}
    Open AddModal
    Verify ModalHeader    เพิ่มหลักสูตร
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'ระดับการศึกษา')]    ระดับการศึกษา
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'แผนก')]    แผนก
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'ชื่อหลักสูตร (TH)')]    ชื่อหลักสูตร (TH)
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'ชื่อหลักสูตร (EN)')]    ชื่อหลักสูตร (EN)
    Verify PlaceholderText    xpath=//input[@id='program_name_th']    กรอกชื่อหลักสูตรเป็นภาษาไทย
    Verify PlaceholderText    xpath=//input[@id='program_name_en']    กรอกชื่อหลักสูตรเป็นภาษาอังกฤษ
    Verify ButtonText    xpath=//button[@id='btn-save']    บันทึก
    Verify ButtonText    xpath=//div[@id='crud-modal']//a[contains(text(), 'ยกเลิก')]    ยกเลิก
    Close Modal
    Switch Language    zh
    Go To    ${PROGRAMS_URL}
    Open AddModal
    Verify ModalHeader    添加课程
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '学历')]    学历
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '系别')]    系别
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '课程名称 (泰语)')]    课程名称 (泰语)
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '课程名称 (英语)')]    课程名称 (英语)
    Verify PlaceholderText    xpath=//input[@id='program_name_th']    请输入泰语课程名称
    Verify PlaceholderText    xpath=//input[@id='program_name_en']    请输入英语课程名称
    Verify ButtonText    xpath=//button[@id='btn-save']    提交
    Verify ButtonText    xpath=//div[@id='crud-modal']//a[contains(text(), '取消')]    取消
    Close Modal

TC41_ADMINPrograms_EditTranslation - ตรวจสอบภาษา form action Edit ของ UI22 ที่ http://127.0.0.1:8000/programs
    [Setup]    Reset Language To English
    Go To    ${PROGRAMS_URL}
    Open EditModal
    Verify ModalHeader    Edit Program
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'Degree')]    Degree
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'Department')]    Department
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'Program Name (TH)')]    Program Name (TH)
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'Program Name (EN)')]    Program Name (EN)
    Verify PlaceholderText    xpath=//input[@id='program_name_th']    Enter program name in Thai
    Verify PlaceholderText    xpath=//input[@id='program_name_en']    Enter program name in English
    Verify ButtonText    xpath=//button[@id='btn-save']    Submit
    Verify ButtonText    xpath=//div[@id='crud-modal']//a[contains(text(), 'Cancel')]    Cancel
    Close Modal
    Switch Language    th
    Go To    ${PROGRAMS_URL}
    Open EditModal
    Verify ModalHeader    แก้ไขหลักสูตร
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'ระดับการศึกษา')]    ระดับการศึกษา
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'แผนก')]    แผนก
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'ชื่อหลักสูตร (TH)')]    ชื่อหลักสูตร (TH)
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), 'ชื่อหลักสูตร (EN)')]    ชื่อหลักสูตร (EN)
    Verify PlaceholderText    xpath=//input[@id='program_name_th']    กรอกชื่อหลักสูตรเป็นภาษาไทย
    Verify PlaceholderText    xpath=//input[@id='program_name_en']    กรอกชื่อหลักสูตรเป็นภาษาอังกฤษ
    Verify ButtonText    xpath=//button[@id='btn-save']    บันทึก
    Verify ButtonText    xpath=//div[@id='crud-modal']//a[contains(text(), 'ยกเลิก')]    ยกเลิก
    Close Modal
    Switch Language    zh
    Go To    ${PROGRAMS_URL}
    Open EditModal
    Verify ModalHeader    編輯程式
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '学历')]    学历
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '系别')]    系别
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '课程名称 (泰语)')]    课程名称 (泰语)
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '课程名称 (英语)')]    课程名称 (英语)
    Verify PlaceholderText    xpath=//input[@id='program_name_th']    请输入泰语课程名称
    Verify PlaceholderText    xpath=//input[@id='program_name_en']    请输入英语课程名称
    Verify ButtonText    xpath=//button[@id='btn-save']    提交
    Verify ButtonText    xpath=//div[@id='crud-modal']//a[contains(text(), '取消')]    取消
    Close Modal

TC44_ADMINPrograms_DeleteTranslation - ตรวจสอบภาษาการลบข้อมูลและpop up ที่แสดงขึ้นมา ของ UI22 ที่ http://127.0.0.1:8000/programs
    [Setup]    Reset Language To English
    Go To    ${PROGRAMS_URL}
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify PopupLanguage    Are you sure?    You will not be able to recover this file!    Delete Successfully
    Switch Language    th
    Go To    ${PROGRAMS_URL}
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify PopupLanguage    คุณแน่ใจหรือไม่?    คุณจะไม่สามารถกู้คืนไฟล์นี้ได้!    ลบข้อมูลสำเร็จ
    Switch Language    zh
    Go To    ${PROGRAMS_URL}
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify PopupLanguage    您确定吗？    您将无法恢复此文件！    删除成功