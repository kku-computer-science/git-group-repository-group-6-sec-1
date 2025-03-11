*** Settings ***
Library         SeleniumLibrary
Suite Setup     Setup Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              Firefox
${PROGRAMS_URL}         http://127.0.0.1:8000/programs
${USERNAME}             admin@gmail.com
${PASSWORD}             12345678
${LOGIN_URL}            http://127.0.0.1:8000/login
${DASHBOARD_URL}        http://127.0.0.1:8000/dashboard
${TIMEOUT}              15s
@{LANGUAGES}            th    zh    en

*** Keywords ***
Setup Browser And Login
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

Switch Language
    [Arguments]    ${lang}
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    5s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'dropdown-menu')]    5s
    ${items}=    Get WebElements    xpath=//div[contains(@class, 'dropdown-menu')]//a
    FOR    ${item}    IN    @{items}
        ${text}=    Get Text    ${item}
        Log To Console    ตัวเลือกใน Dropdown: ${text}
    END
    ${lang_text}=    Set Variable If
    ...    '${lang}' == 'th'    ไทย
    ...    '${lang}' == 'zh'    中国
    ...    '${lang}' == 'en'    English
    ${lang_option}=    Run Keyword And Return Status    Element Should Be Visible    xpath=//a[contains(., '${lang_text}')]
    Run Keyword If    ${lang_option}    Click Element    xpath=//a[contains(., '${lang_text}')]
    ...    ELSE    Fail    ไม่พบตัวเลือกภาษา ${lang_text} ใน dropdown
    Go To    ${PROGRAMS_URL}
    ${title_text}=    Set Variable If
    ...    '${lang}' == 'th'    หลักสูตร
    ...    '${lang}' == 'zh'    课程
    ...    '${lang}' == 'en'    Programs
    Wait Until Page Contains    ${title_text}    10s
    Log To Console    เปลี่ยนภาษาเป็น: ${lang}

Verify Page Language
    [Arguments]    ${expected_text}
    Wait Until Page Contains    ${expected_text}    10s
    Log To Console    ตรวจสอบข้อความในหน้า: ${expected_text}

Verify Table Header
    [Arguments]    ${column}    ${expected_text}
    Wait Until Element Is Visible    xpath=//table[@id='example1']//thead//th[${column}]    5s
    ${actual_text}=    Get Text    xpath=//table[@id='example1']//thead//th[${column}]
    Should Be Equal As Strings    ${actual_text}    ${expected_text}
    Log To Console    ตรวจสอบหัวตารางคอลัมน์ ${column}: ${expected_text}

Open AddModal
    ${button_exists}=    Run Keyword And Return Status    Element Should Be Visible    xpath=//a[@id='new-program']
    Run Keyword If    ${button_exists}    Click Element    xpath=//a[@id='new-program']
    ...    ELSE    Log To Console    ไม่พบปุ่ม new-program
    Run Keyword If    ${button_exists}    Sleep    3s
    Run Keyword If    ${button_exists}    Wait Until Element Is Visible    xpath=//div[contains(@class, 'modal') and @id='crud-modal']    20s
    Run Keyword If    ${button_exists}    Log To Console    เปิด Modal เพิ่มข้อมูล
    ...    ELSE    Fail    ไม่สามารถเปิด Modal เพิ่มข้อมูลได้

Verify ModalHeader
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//h4[@id='programCrudModal']    5s
    ${actual_text}=    Get Text    xpath=//h4[@id='programCrudModal']
    Should Be Equal As Strings    ${actual_text}    ${expected_text}
    Log To Console    ตรวจสอบหัวข้อ Modal: ${expected_text}

Verify FormLabel
    [Arguments]    ${label_xpath}    ${expected_text}
    Wait Until Element Is Visible    ${label_xpath}    5s
    ${actual_text}=    Get Text    ${label_xpath}
    Should Be Equal As Strings    ${actual_text}    ${expected_text}
    Log To Console    ตรวจสอบป้ายกำกับ: ${expected_text}

Verify PlaceholderText
    [Arguments]    ${input_xpath}    ${expected_text}
    Wait Until Element Is Visible    ${input_xpath}    5s
    ${actual_placeholder}=    Get Element Attribute    ${input_xpath}    placeholder
    Should Be Equal As Strings    ${actual_placeholder}    ${expected_text}
    Log To Console    ตรวจสอบข้อความตัวอย่าง: ${expected_text}

Verify ButtonText
    [Arguments]    ${button_xpath}    ${expected_text}
    Wait Until Element Is Visible    ${button_xpath}    5s
    ${actual_text}=    Get Text    ${button_xpath}
    Should Be Equal As Strings    ${actual_text}    ${expected_text}
    Log To Console    ตรวจสอบปุ่ม: ${expected_text}

Open EditModal
    ${button_exists}=    Run Keyword And Return Status    Element Should Be Visible    xpath=//a[@id='edit-program'][1]
    Run Keyword If    ${button_exists}    Click Element    xpath=//a[@id='edit-program'][1]
    ...    ELSE    Log To Console    ไม่พบปุ่ม edit-program (อาจไม่มีข้อมูลในตาราง)
    Run Keyword If    ${button_exists}    Sleep    3s
    Run Keyword If    ${button_exists}    Wait Until Element Is Visible    xpath=//div[contains(@class, 'modal') and @id='crud-modal']    20s
    Run Keyword If    ${button_exists}    Log To Console    เปิด Modal แก้ไขข้อมูล
    ...    ELSE    Fail    ไม่สามารถเปิด Modal แก้ไขข้อมูลได้

Close Modal
    [Arguments]    ${cancel_text}
    Wait Until Element Is Visible    xpath=//div[@id='crud-modal']//a[contains(text(), '${cancel_text}')]    5s
    Click Element    xpath=//div[@id='crud-modal']//a[contains(text(), '${cancel_text}')]
    Wait Until Element Is Not Visible    xpath=//div[@id='crud-modal']    5s
    Log To Console    ปิด Modal

Add Test Data
    Log To Console    เพิ่มข้อมูลทดสอบ...
    Go To    ${PROGRAMS_URL}
    Open AddModal
    Input Text    xpath=//input[@id='program_name_th']    Test Program TH
    Input Text    xpath=//input[@id='program_name_en']    Test Program EN
    Select From List By Index    xpath=//select[@id='degree']    1
    Select From List By Index    xpath=//select[@id='department']    1
    Click Button    xpath=//button[@id='btn-save']
    Wait Until Element Is Visible    xpath=//table[@id='example1']//tbody//tr    10s
    # รอให้ป๊อปอัพสำเร็จหายไป
    Wait Until Element Is Not Visible    xpath=//div[contains(@class, 'swal2-container')]    15s
    Execute JavaScript    document.querySelectorAll('.swal2-container').forEach(el => el.remove());
    Sleep    2s    # รอให้ overlay หาย

Verify TC44
    [Arguments]    ${lang}
    # ไปที่หน้าโปรแกรมและเปลี่ยนภาษา
    Switch Language    ${lang}
    Go To    ${PROGRAMS_URL}
    Log To Console    เริ่มทดสอบการลบในภาษา: ${lang}...

    # ตรวจสอบและเพิ่มข้อมูลทดสอบถ้าจำเป็น
    ${row_count}=    Get Element Count    xpath=//table[@id='example1']//tbody//tr
    Run Keyword If    ${row_count} == 0    Add Test Data
    ${row_count}=    Get Element Count    xpath=//table[@id='example1']//tbody//tr
    Run Keyword If    ${row_count} == 0    Fail    ไม่มีข้อมูลในตารางสำหรับการลบ แม้จะเพิ่มข้อมูลแล้ว

    # ตรวจสอบและคลิกปุ่มลบแรก
    ${delete_button_status}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//button[contains(@class, 'show_confirm')][1]    timeout=15s
    Run Keyword If    not ${delete_button_status}    Fail    ไม่พบปุ่มลบ (Delete button not found)
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Log To Console    คลิกปุ่มลบแล้ว

    # กำหนดข้อความที่คาดหวังตามภาษา
    ${expected_title}=    Set Variable If
    ...    '${lang}' == 'th'    คุณแน่ใจหรือไม่?
    ...    '${lang}' == 'zh'    你确定吗？
    ...    '${lang}' == 'en'    Are you sure?
    ${expected_text}=    Set Variable If
    ...    '${lang}' == 'th'    หากคุณลบข้อมูลนี้ จะไม่สามารถกู้คืนได้
    ...    '${lang}' == 'zh'    如果删除，数据将永远消失。
    ...    '${lang}' == 'en'    You will not be able to recover this file!
    ${cancel_text}=    Set Variable If
    ...    '${lang}' == 'th'    ยกเลิก
    ...    '${lang}' == 'zh'    取消
    ...    '${lang}' == 'en'    Cancel
    ${ok_text}=    Set Variable If
    ...    '${lang}' == 'th'    ตกลง
    ...    '${lang}' == 'zh'    确定
    ...    '${lang}' == 'en'    OK

    # ตรวจสอบข้อความใน Popup
    ${popup_title_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-title')]    timeout=15s
    Run Keyword If    not ${popup_title_status}    Fail    ไม่พบหัวข้อป๊อปอัพ (Popup title not found)
    ${popup_title}=    Get Text    xpath=//div[contains(@class, 'swal-title')]
    Run Keyword If    "${popup_title}" != "${expected_title}"    Fail    หัวข้อป๊อปอัพไม่ตรง: คาดว่า "${expected_title}", ได้ "${popup_title}"
    Log To Console    หัวข้อป๊อปอัพ: ${popup_title}

    ${popup_text_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-text')]    timeout=15s
    Run Keyword If    not ${popup_text_status}    Fail    ไม่พบข้อความป๊อปอัพ (Popup text not found)
    ${popup_text}=    Get Text    xpath=//div[contains(@class, 'swal-text')]
    Run Keyword If    "${popup_text}" != "${expected_text}"    Fail    ข้อความป๊อปอัพไม่ตรง: คาดว่า "${expected_text}", ได้ "${popup_text}"
    Log To Console    ข้อความป๊อปอัพ: ${popup_text}

    # ตรวจสอบปุ่ม Cancel และ OK
    ${cancel_button_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//button[contains(text(), '${cancel_text}')]    timeout=15s
    Run Keyword If    not ${cancel_button_status}    Fail    ไม่พบปุ่มยกเลิก (Cancel button not found)
    ${ok_button_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//button[contains(text(), '${ok_text}')]    timeout=15s
    Run Keyword If    not ${ok_button_status}    Fail    ไม่พบปุ่มตกลง (OK button not found)
    Log To Console    ตรวจสอบปุ่มยกเลิกและตกลงเรียบร้อย

    # คลิกยกเลิกเพื่อปิด Popup
    Click Element    xpath=//button[contains(text(), '${cancel_text}')]
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'card')]    timeout=15s
    Log To Console    ยกเลิกการลบ กลับสู่หน้าโปรแกรม

Logout And Close Browser
    Go To    ${DASHBOARD_URL}
    Click Element    xpath=//a[contains(@href, '/logout')]
    Wait Until Location Contains    ${LOGIN_URL}    ${TIMEOUT}
    Log To Console    ออกจากระบบสำเร็จ
    Close Browser

Run Test For All Languages
    [Arguments]    ${test_keyword}
    Go To    ${PROGRAMS_URL}
    FOR    ${lang}    IN    @{LANGUAGES}
        Switch Language    ${lang}
        Run Keyword    ${test_keyword}    ${lang}
    END

Verify TC43
    [Arguments]    ${lang}
    ${title_text}=    Set Variable If
    ...    '${lang}' == 'th'    หลักสูตร
    ...    '${lang}' == 'zh'    课程
    ...    '${lang}' == 'en'    Programs
    ${add_text}=    Set Variable If
    ...    '${lang}' == 'th'    เพิ่มโปรแกรม
    ...    '${lang}' == 'zh'    添加程序
    ...    '${lang}' == 'en'    Add Program
    Verify Page Language    ${title_text}
    Verify Page Language    ${add_text}

Verify TC42
    [Arguments]    ${lang}
    ${id_text}=    Set Variable If
    ...    '${lang}' == 'th'    รหัส
    ...    '${lang}' == 'zh'    编号
    ...    '${lang}' == 'en'    ID
    ${name_th_text}=    Set Variable If
    ...    '${lang}' == 'th'    ชื่อหลักสูตร (TH)
    ...    '${lang}' == 'zh'    课程名称 (泰语)
    ...    '${lang}' == 'en'    Program Name (TH)
    ${degree_text}=    Set Variable If
    ...    '${lang}' == 'th'    ระดับการศึกษา
    ...    '${lang}' == 'zh'    学历
    ...    '${lang}' == 'en'    Degree
    ${action_text}=    Set Variable If
    ...    '${lang}' == 'th'    การกระทำ
    ...    '${lang}' == 'zh'    操作
    ...    '${lang}' == 'en'    Action
    Verify Table Header    1    ${id_text}
    Verify Table Header    2    ${name_th_text}
    Verify Table Header    3    ${degree_text}
    Verify Table Header    4    ${action_text}

Verify TC40
    [Arguments]    ${lang}
    Open AddModal
    ${header_text}=    Set Variable If
    ...    '${lang}' == 'th'    เพิ่มโปรแกรม
    ...    '${lang}' == 'zh'    添加程序
    ...    '${lang}' == 'en'    Add Program
    ${degree_text}=    Set Variable If
    ...    '${lang}' == 'th'    ระดับการศึกษา:
    ...    '${lang}' == 'zh'    学历:
    ...    '${lang}' == 'en'    Degree:
    ${dept_text}=    Set Variable If
    ...    '${lang}' == 'th'    แผนก:
    ...    '${lang}' == 'zh'    系别:
    ...    '${lang}' == 'en'    Department:
    ${name_th_text}=    Set Variable If
    ...    '${lang}' == 'th'    ชื่อหลักสูตร (TH):
    ...    '${lang}' == 'zh'    课程名称 (泰语):
    ...    '${lang}' == 'en'    Program Name (TH):
    ${name_en_text}=    Set Variable If
    ...    '${lang}' == 'th'    ชื่อหลักสูตร (EN):
    ...    '${lang}' == 'zh'    课程名称 (英语):
    ...    '${lang}' == 'en'    Program Name (EN):
    ${placeholder_th}=    Set Variable If
    ...    '${lang}' == 'th'    กรอกชื่อหลักสูตรเป็นภาษาไทย
    ...    '${lang}' == 'zh'    请输入泰语课程名称
    ...    '${lang}' == 'en'    Enter program name in Thai
    ${placeholder_en}=    Set Variable If
    ...    '${lang}' == 'th'    กรอกชื่อหลักสูตรเป็นภาษาอังกฤษ
    ...    '${lang}' == 'zh'    请输入英语课程名称
    ...    '${lang}' == 'en'    Enter program name in English
    ${submit_text}=    Set Variable If
    ...    '${lang}' == 'th'    บันทึก
    ...    '${lang}' == 'zh'    提交
    ...    '${lang}' == 'en'    Submit
    ${cancel_text}=    Set Variable If
    ...    '${lang}' == 'th'    ยกเลิก
    ...    '${lang}' == 'zh'    取消
    ...    '${lang}' == 'en'    Cancel
    Verify ModalHeader    ${header_text}
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '${degree_text}')]    ${degree_text}
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '${dept_text}')]    ${dept_text}
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '${name_th_text}')]    ${name_th_text}
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '${name_en_text}')]    ${name_en_text}
    Verify PlaceholderText    xpath=//input[@id='program_name_th']    ${placeholder_th}
    Verify PlaceholderText    xpath=//input[@id='program_name_en']    ${placeholder_en}
    Verify ButtonText    xpath=//button[@id='btn-save']    ${submit_text}
    Verify ButtonText    xpath=//div[@id='crud-modal']//a[contains(text(), '${cancel_text}')]    ${cancel_text}
    Close Modal    ${cancel_text}

Verify TC41
    [Arguments]    ${lang}
    Open EditModal
    ${header_text}=    Set Variable If
    ...    '${lang}' == 'th'    แก้ไขโปรแกรม
    ...    '${lang}' == 'zh'    编辑程序
    ...    '${lang}' == 'en'    Edit Program
    ${degree_text}=    Set Variable If
    ...    '${lang}' == 'th'    ระดับการศึกษา:
    ...    '${lang}' == 'zh'    学历:
    ...    '${lang}' == 'en'    Degree:
    ${dept_text}=    Set Variable If
    ...    '${lang}' == 'th'    แผนก:
    ...    '${lang}' == 'zh'    系别:
    ...    '${lang}' == 'en'    Department:
    ${name_th_text}=    Set Variable If
    ...    '${lang}' == 'th'    ชื่อหลักสูตร (TH):
    ...    '${lang}' == 'zh'    课程名称 (泰语):
    ...    '${lang}' == 'en'    Program Name (TH):
    ${name_en_text}=    Set Variable If
    ...    '${lang}' == 'th'    ชื่อหลักสูตร (EN):
    ...    '${lang}' == 'zh'    课程名称 (英语):
    ...    '${lang}' == 'en'    Program Name (EN):
    ${placeholder_th}=    Set Variable If
    ...    '${lang}' == 'th'    กรอกชื่อหลักสูตรเป็นภาษาไทย
    ...    '${lang}' == 'zh'    请输入泰语课程名称
    ...    '${lang}' == 'en'    Enter program name in Thai
    ${placeholder_en}=    Set Variable If
    ...    '${lang}' == 'th'    กรอกชื่อหลักสูตรเป็นภาษาอังกฤษ
    ...    '${lang}' == 'zh'    请输入英语课程名称
    ...    '${lang}' == 'en'    Enter program name in English
    ${submit_text}=    Set Variable If
    ...    '${lang}' == 'th'    บันทึก
    ...    '${lang}' == 'zh'    提交
    ...    '${lang}' == 'en'    Submit
    ${cancel_text}=    Set Variable If
    ...    '${lang}' == 'th'    ยกเลิก
    ...    '${lang}' == 'zh'    取消
    ...    '${lang}' == 'en'    Cancel
    Verify ModalHeader    ${header_text}
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '${degree_text}')]    ${degree_text}
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '${dept_text}')]    ${dept_text}
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '${name_th_text}')]    ${name_th_text}
    Verify FormLabel    xpath=//div[@id='crud-modal']//strong[contains(text(), '${name_en_text}')]    ${name_en_text}
    Verify PlaceholderText    xpath=//input[@id='program_name_th']    ${placeholder_th}
    Verify PlaceholderText    xpath=//input[@id='program_name_en']    ${placeholder_en}
    Verify ButtonText    xpath=//button[@id='btn-save']    ${submit_text}
    Verify ButtonText    xpath=//div[@id='crud-modal']//a[contains(text(), '${cancel_text}')]    ${cancel_text}
    Close Modal    ${cancel_text}

*** Test Cases ***
TC43_ADMINPrograms - ตรวจสอบภาษาส่วนต่างๆ ของ UI
    [Documentation]    ตรวจสอบภาษาส่วนต่างๆ ของ UI ที่ http://127.0.0.1:8000/programs
    Run Test For All Languages    Verify TC43

TC42_ADMINPrograms_TableTranslation - ตรวจสอบภาษาในตาราง
    [Documentation]    ตรวจสอบภาษาในตาราง ของ UI ที่ http://127.0.0.1:8000/programs
    Run Test For All Languages    Verify TC42

TC40_ADMINPrograms_FormTranslation - ตรวจสอบภาษาของฟอร์มเพิ่มข้อมูล
    [Documentation]    ตรวจสอบภาษาของฟอร์มเพิ่มข้อมูล ที่ http://127.0.0.1:8000/programs
    Run Test For All Languages    Verify TC40

TC41_ADMINPrograms_EditTranslation - ตรวจสอบภาษาของฟอร์มแก้ไขข้อมูล
    [Documentation]    ตรวจสอบภาษาของฟอร์มแก้ไขข้อมูล ที่ http://127.0.0.1:8000/programs
    Run Test For All Languages    Verify TC41

TC44_ADMINPrograms_DeleteTranslation - ตรวจสอบภาษาของป๊อปอัพการลบ
    [Documentation]    ตรวจสอบภาษาการลบข้อมูลและป๊อปอัพ ที่ http://127.0.0.1:8000/programs
    Run Test For All Languages    Verify TC44