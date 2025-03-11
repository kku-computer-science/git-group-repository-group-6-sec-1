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
${TIMEOUT}              30s
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
    ${lang_option}=    Wait Until Element Is Visible    xpath=//a[contains(., '${lang_text}')]    5s
    Run Keyword If    ${lang_option}    Click Element    xpath=//a[contains(., '${lang_text}')]
    ...    ELSE    Fail    ไม่พบตัวเลือกภาษา ${lang_text} ใน dropdown
    Go To    ${PROGRAMS_URL}
    ${title_text}=    Set Variable If
    ...    '${lang}' == 'th'    หลักสูตร
    ...    '${lang}' == 'zh'    课程
    ...    '${lang}' == 'en'    Programs
    Wait Until Element Is Visible    xpath=//h4[contains(text(), '${title_text}')]    15s
    Log To Console    เปลี่ยนภาษาเป็น: ${lang}

Verify TC44
    [Arguments]    ${lang}
    # ไปที่หน้าโปรแกรมและรอให้ตารางโหลด
    Go To    ${PROGRAMS_URL}
    Wait Until Element Is Visible    xpath=//table[@id='example1']    ${TIMEOUT}

    # ตรวจสอบว่ามีข้อมูลในตาราง ถ้าไม่มีให้เพิ่มข้อมูลทดสอบ
    ${row_count}=    Get Element Count    xpath=//table[@id='example1']//tbody//tr
    Run Keyword If    ${row_count} == 0    Add Test Data
    ${row_count}=    Get Element Count    xpath=//table[@id='example1']//tbody//tr
    Run Keyword If    ${row_count} == 0    Fail    ไม่มีข้อมูลในตารางสำหรับการลบ แม้จะเพิ่มข้อมูลแล้ว

    # เปลี่ยนภาษาและรอหน้าโหลด
    Switch Language    ${lang}

    # ตรวจสอบและคลิกปุ่มลบ
    ${delete_button}=    Wait Until Element Is Visible    xpath=//button[contains(@class, 'show_confirm')][1]    10s
    Run Keyword If    ${delete_button}    Log To Console    พบปุ่มลบข้อมูล
    ...    ELSE    Fail    ไม่พบปุ่ม show_confirm (อาจไม่มีข้อมูลในตาราง)
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]

    # กำหนดข้อความที่คาดหวังตามภาษา
    ${title_text}=    Set Variable If
    ...    '${lang}' == 'th'    คุณแน่ใจหรือไม่?
    ...    '${lang}' == 'zh'    你确定吗？
    ...    '${lang}' == 'en'    Are you sure?
    ${confirm_text}=    Set Variable If
    ...    '${lang}' == 'th'    หากคุณลบข้อมูลนี้ จะไม่สามารถกู้คืนได้
    ...    '${lang}' == 'zh'    如果删除，数据将永远消失。
    ...    '${lang}' == 'en'    You will not be able to recover this file!

    # รอและตรวจสอบป๊อปอัพยืนยัน
    ${popup_visible}=    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-modal')]    30s
    Run Keyword If    ${popup_visible}    Log To Console    พบป๊อปอัพยืนยันการลบ
    ...    ELSE    Fail    ไม่พบป๊อปอัพยืนยันการลบภายใน 30 วินาที
    ${actual_title}=    Get Text    xpath=//div[contains(@class, 'swal-modal')]//div[contains(@class, 'swal-title')]
    Should Be Equal As Strings    ${actual_title}    ${title_text}    msg=หัวข้อป๊อปอัพไม่ตรง: คาดว่า '${title_text}' แต่ได้ '${actual_title}'
    ${actual_text}=    Get Text    xpath=//div[contains(@class, 'swal-modal')]//div[contains(@class, 'swal-text')]
    Should Contain    ${actual_text}    ${confirm_text}    msg=ข้อความยืนยันไม่ตรง: คาดว่า '${confirm_text}' แต่ได้ '${actual_text}'

    # กดปุ่ม "OK" ในป๊อปอัพยืนยัน
    ${ok_button}=    Wait Until Element Is Visible    xpath=//button[contains(@class, 'swal-button--confirm')]    10s
    Run Keyword If    ${ok_button}    Log To Console    พบปุ่ม "OK" ในป๊อปอัพ
    ...    ELSE    Fail    ไม่พบปุ่ม "OK" ในป๊อปอัพภายใน 10 วินาที
    Click Element    xpath=//button[contains(@class, 'swal-button--confirm')]

    # รอป๊อปอัพผลลัพธ์
    ${success_popup}=    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-modal')]    30s
    Run Keyword If    ${success_popup}    Log To Console    พบป๊อปอัพผลลัพธ์
    ...    ELSE    Fail    ไม่พบป๊อปอัพผลลัพธ์ภายใน 30 วินาที
    ${actual_success}=    Get Text    xpath=//div[contains(@class, 'swal-modal')]//div[contains(@class, 'swal-title')]
    ${expected_success}=    Set Variable If
    ...    '${lang}' == 'th'    ลบสำเร็จ
    ...    '${lang}' == 'zh'    删除成功
    ...    '${lang}' == 'en'    Delete Successfully
    Should Be Equal As Strings    ${actual_success}    ${expected_success}    msg=ข้อความสำเร็จไม่ตรง: คาดว่า '${expected_success}' แต่ได้ '${actual_success}'

    # กดปุ่ม "OK" ในป๊อปอัพผลลัพธ์
    ${success_ok_button}=    Wait Until Element Is Visible    xpath=//button[contains(@class, 'swal-button--confirm')]    10s
    Run Keyword If    ${success_ok_button}    Click Element    xpath=//button[contains(@class, 'swal-button--confirm')]
    ...    ELSE    Fail    ไม่พบปุ่ม "OK" ในป๊อปอัพผลลัพธ์ภายใน 10 วินาที

    # รอให้หน้าโหลดใหม่
    Wait Until Element Is Visible    xpath=//table[@id='example1']    ${TIMEOUT}

    # ตรวจสอบว่าข้อมูลถูกลบออกจากตาราง
    ${row_count_after_delete}=    Get Element Count    xpath=//table[@id='example1']//tbody//tr
    Should Be True    ${row_count_after_delete} < ${row_count}    msg=ข้อมูลไม่ถูกลบออกจากตาราง

    Log To Console    ตรวจสอบป๊อปอัพสำเร็จสำหรับภาษา: ${lang}

Add Test Data
    Log To Console    เพิ่มข้อมูลทดสอบ...
    Go To    ${PROGRAMS_URL}
    Wait Until Element Is Visible    xpath=//a[@id='new-program']    10s
    Click Element    xpath=//a[@id='new-program']
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'modal') and @id='crud-modal']    20s
    Input Text    xpath=//input[@id='program_name_th']    Test Program TH
    Input Text    xpath=//input[@id='program_name_en']    Test Program EN
    Select From List By Index    xpath=//select[@id='degree']    1
    Select From List By Index    xpath=//select[@id='department']    1
    Click Button    xpath=//button[@id='btn-save']
    Wait Until Element Is Visible    xpath=//table[@id='example1']//tbody//tr    20s
    Wait Until Element Is Not Visible    xpath=//div[contains(@class, 'swal-modal')]    ELSE    Log To Console    ไม่มีป๊อปอัพค้างหลังเพิ่มข้อมูล

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

*** Test Cases ***
TC44_ADMINPrograms_DeleteTranslation
    [Documentation]    ตรวจสอบภาษาของป๊อปอัพการลบข้อมูลในหน้าโปรแกรม
    [Tags]    TC44    DeleteTranslation
    Run Test For All Languages    Verify TC44