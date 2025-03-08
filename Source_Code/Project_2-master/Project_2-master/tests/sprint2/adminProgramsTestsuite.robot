*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              Firefox
${PROGRAMS_URL}         http://127.0.0.1:8000/programs
${USERNAME}             admin@gmail.com    # ปรับตามผู้ใช้จริง
${PASSWORD}             12345678           # ปรับตามรหัสผ่านจริง
${LOGIN_URL}            http://127.0.0.1:8000/login
${DASHBOARD_URL}        http://127.0.0.1:8000/dashboard
${TIMEOUT}              30s

*** Keywords ***
Open Browser And Login
    Open Browser    ${LOGIN_URL}    ${BROWSER}
    Maximize Browser Window
    Set Selenium Timeout    ${TIMEOUT}
    Login To System

Login To System
    Wait Until Page Contains Element    id=username    ${TIMEOUT}
    Input Text    id=username    ${USERNAME}
    Input Text    id=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit']
    Wait Until Location Contains    ${DASHBOARD_URL}    ${TIMEOUT}
    Log To Console    เข้าสู่ระบบสำเร็จ, ไปที่: ${DASHBOARD_URL}

Reset Language To Thai
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    ${TIMEOUT}
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'dropdown-menu')]    ${TIMEOUT}
    ${items}=    Get WebElements    xpath=//div[contains(@class, 'dropdown-menu')]//a
    FOR    ${item}    IN    @{items}
        ${text}=    Get Text    ${item}
        Log To Console    ตัวเลือกใน Dropdown: ${text}
    END
    Click Element    xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(text(), 'ไทย')]
    Sleep    2s
    Wait Until Page Contains Element    xpath=//span[contains(@class, 'flag-icon-th')]    ${TIMEOUT}
    Log To Console    รีเซ็ตภาษาเป็น ไทย

Switch Language
    [Arguments]    ${lang}
    ${lang_text}=    Set Variable If    '${lang}' == 'th'    ไทย    '${lang}' == 'zh'    中国
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    ${TIMEOUT}
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'dropdown-menu')]    ${TIMEOUT}
    ${items}=    Get WebElements    xpath=//div[contains(@class, 'dropdown-menu')]//a
    FOR    ${item}    IN    @{items}
        ${text}=    Get Text    ${item}
        Log To Console    ตัวเลือกใน Dropdown: ${text}
    END
    Click Element    xpath=//div[contains(@class, 'dropdown-menu')]//a[contains(text(), '${lang_text}')]
    Sleep    2s
    ${flag}=    Run Keyword If    '${lang}' == 'zh'    Set Variable    cn    ELSE    Set Variable    ${lang}
    Wait Until Page Contains Element    xpath=//span[contains(@class, 'flag-icon-${flag}')]    ${TIMEOUT}
    Log To Console    เปลี่ยนภาษาเป็น: ${lang}

Verify Page Language
    [Arguments]    ${expected_text}
    Wait Until Page Contains    ${expected_text}    ${TIMEOUT}
    Log To Console    ตรวจสอบข้อความในหน้า: ${expected_text}

Verify ModalHeader
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//div[@id='crud-modal']//h4[@id='programCrudModal']    ${TIMEOUT}
    ${actual_text}=    Get Text    xpath=//div[@id='crud-modal']//h4[@id='programCrudModal']
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    ตรวจสอบหัวข้อ Modal: ${expected_text}

Verify Table Header
    [Arguments]    ${column}    ${expected_text}
    Wait Until Element Is Visible    xpath=//table//thead//th[${column}]    ${TIMEOUT}
    ${actual_text}=    Get Text    xpath=//table//thead//th[${column}]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    ตรวจสอบหัวตารางคอลัมน์ ${column}: ${expected_text}

Open AddModal
    Go To    ${PROGRAMS_URL}
    Wait Until Element Is Visible    xpath=//a[@id='new-program']    ${TIMEOUT}
    Click Element    xpath=//a[@id='new-program']
    Sleep    3s
    Wait Until Element Is Visible    xpath=//div[@id='crud-modal']//h4[@id='programCrudModal']    ${TIMEOUT}
    Log To Console    เปิด Modal เพิ่มข้อมูล

Verify FormLabel
    [Arguments]    ${label_xpath}    ${expected_text}
    Wait Until Element Is Visible    ${label_xpath}    ${TIMEOUT}
    ${actual_text}=    Get Text    ${label_xpath}
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    ตรวจสอบป้ายกำกับ: ${expected_text}

Verify PlaceholderText
    [Arguments]    ${input_xpath}    ${expected_placeholder}
    Wait Until Element Is Visible    ${input_xpath}    ${TIMEOUT}
    ${actual_placeholder}=    Get Element Attribute    ${input_xpath}    placeholder
    Should Contain    ${actual_placeholder}    ${expected_placeholder}
    Log To Console    ตรวจสอบข้อความตัวอย่าง: ${expected_placeholder}

Verify ButtonText
    [Arguments]    ${button_xpath}    ${expected_text}
    Wait Until Element Is Visible    ${button_xpath}    ${TIMEOUT}
    ${actual_text}=    Get Text    ${button_xpath}
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    ตรวจสอบปุ่ม: ${expected_text}

Open EditModal
    Go To    ${PROGRAMS_URL}
    Wait Until Element Is Visible    xpath=//a[@id='edit-program'][1]    ${TIMEOUT}
    Click Element    xpath=//a[@id='edit-program'][1]
    Sleep    3s
    Wait Until Element Is Visible    xpath=//div[@id='crud-modal']//h4[@id='programCrudModal']    ${TIMEOUT}
    Log To Console    เปิด Modal แก้ไขข้อมูล

Close Modal
    Click Element    xpath=//div[@id='crud-modal']//a[contains(text(), 'Cancel')]
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'card-body')]    ${TIMEOUT}
    Log To Console    ปิด Modal

Verify PopupLanguage
    [Arguments]    ${expected_title}    ${expected_text}    ${expected_success}
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-title')]    ${TIMEOUT}
    ${title}=    Get Text    xpath=//div[contains(@class, 'swal-title')]
    Should Contain    ${title}    ${expected_title}
    ${text}=    Get Text    xpath=//div[contains(@class, 'swal-text')]
    Should Contain    ${text}    ${expected_text}
    Click Element    xpath=//button[contains(@class, 'swal-button--confirm')]
    Sleep    3s
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'card-body')]    ${TIMEOUT}
    Log To Console    ตรวจสอบป๊อปอัพ: ${expected_title}, ${expected_text}, ${expected_success}

Logout And Close Browser
    Go To    ${DASHBOARD_URL}
    Click Element    xpath=//a[contains(@href, '/logout')]
    Wait Until Location Contains    ${LOGIN_URL}    ${TIMEOUT}
    Log To Console    ออกจากระบบสำเร็จ
    Close Browser

*** Test Cases ***
TC43_ADMINPrograms - ตรวจสอบภาษาส่วนต่างๆ ของ UI
    [Setup]    Reset Language To Thai
    Go To    ${PROGRAMS_URL}
    Verify Page Language    หลักสูตร
    Verify Page Language    เพิ่มหลักสูตร
    Switch Language    zh
    Go To    ${PROGRAMS_URL}
    Verify Page Language    课程
    Verify Page Language    添加课程

TC42_ADMINPrograms_TableTranslation - ตรวจสอบภาษาในตาราง
    [Setup]    Reset Language To Thai
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

TC40_ADMINPrograms_FormTranslation - ตรวจสอบภาษาของฟอร์มเพิ่มข้อมูล
    [Setup]    Reset Language To Thai
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

TC41_ADMINPrograms_EditTranslation - ตรวจสอบภาษาของฟอร์มแก้ไขข้อมูล
    [Setup]    Reset Language To Thai
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

TC44_ADMINPrograms_DeleteTranslation - ตรวจสอบภาษาของป๊อปอัพการลบ
    [Setup]    Reset Language To Thai
    Go To    ${PROGRAMS_URL}
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify PopupLanguage    คุณแน่ใจหรือไม่?    คุณจะไม่สามารถกู้คืนไฟล์นี้ได้!    ลบข้อมูลสำเร็จ
    Switch Language    zh
    Go To    ${PROGRAMS_URL}
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Verify PopupLanguage    您确定吗？    您将无法恢复此文件！    删除成功