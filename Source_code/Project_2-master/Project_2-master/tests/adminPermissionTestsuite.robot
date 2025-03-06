ผมเข้าใจแล้วครับ คุณต้องการให้รวมและใช้ส่วน TC43_ADMINPermission จากไฟล์ที่ 2 แทนที่จะใช้จากไฟล์แรก เนื่องจากโค้ดในไฟล์ที่ 2 สามารถใช้งานได้ดีกว่า

```robotframework
*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              Firefox
${PERMISSIONS_URL}      http://127.0.0.1:8000/permissions
${CREATE_URL}           http://127.0.0.1:8000/permissions/create
${VALID_PERMISSION_ID}  1    # เปลี่ยนตาม ID ที่มีจริงในฐานข้อมูล
${VIEW_URL}             http://127.0.0.1:8000/permissions/${VALID_PERMISSION_ID}
${EDIT_URL}             http://127.0.0.1:8000/permissions/${VALID_PERMISSION_ID}/edit
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
    Wait Until Element Is Visible    id=username    timeout=15s
    Input Text    id=username    ${USERNAME}
    Input Text    id=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit']
    Wait Until Location Contains    ${DASHBOARD_URL}    timeout=15s
    Log To Console    Login successful, redirected to: ${DASHBOARD_URL}

Reset Language To English
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=15s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    ${english_present}=    Run Keyword And Return Status    Element Should Be Visible    xpath=//a[contains(., 'English')]
    Run Keyword If    not ${english_present}    Fail    English language option not found
    Click Element    xpath=//a[contains(., 'English')]
    Wait Until Element Is Visible    xpath=//span[contains(@class, 'flag-icon-us')]    timeout=10s
    Wait Until Page Contains    Research Information Management System    timeout=15s
    Log To Console    Reset language to English

Switch Language
    [Arguments]    ${lang}
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=15s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    Click Element    xpath=//a[contains(@href, '/lang/${lang}')]
    ${flag}=    Run Keyword If    '${lang}' == 'zh'    Set Variable    cn    ELSE    Set Variable    ${lang}
    Wait Until Element Is Visible    xpath=//span[contains(@class, 'flag-icon-${flag}')]    timeout=10s
    Run Keyword If    '${lang}' == 'en'    Wait Until Page Contains    Research Information Management System    timeout=15s
    Run Keyword If    '${lang}' == 'th'    Wait Until Page Contains    ระบบจัดการข้อมูลวิจัย    timeout=15s
    Run Keyword If    '${lang}' == 'zh'    Wait Until Page Contains    研究信息管理系统    timeout=15s
    Log To Console    Switched to language: ${lang}

Verify Page Language
    [Arguments]    ${expected_title}    ${expected_new_button}=None
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'card-header')]    timeout=15s
    ${actual_text}=    Get Text    xpath=//div[contains(@class, 'card-header')]
    Log To Console    Actual card header text: ${actual_text}
    Should Contain    ${actual_text}    ${expected_title}
    Run Keyword If    '${expected_new_button}' != 'None'    Should Contain    ${actual_text}    ${expected_new_button}
    Run Keyword If    '${expected_new_button}' != 'None'    Log To Console    Verified title: ${expected_title}, new button: ${expected_new_button}
    ...    ELSE    Log To Console    Verified text: ${expected_title}

Verify Button Text
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//button[@type='submit']    timeout=15s
    ${actual_text}=    Get Text    xpath=//button[@type='submit']
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified button text: ${expected_text}

Verify New Permission Button
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'btn btn-primary')]    timeout=15s
    ${actual_text}=    Get Text    xpath=//a[contains(@class, 'btn btn-primary')]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified new permission button text: ${expected_text}

Verify Table Header
    [Arguments]    ${column}    ${expected_text}
    Wait Until Element Is Visible    xpath=//table    timeout=15s    # ตรวจสอบว่าตารางโหลดแล้ว
    Wait Until Element Is Visible    xpath=//table//thead//th[${column}]    timeout=15s
    ${actual_text}=    Get Text    xpath=//table//thead//th[${column}]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified table header column ${column}: ${expected_text}

Verify Popup Language
    [Arguments]    ${expected_title}    ${expected_text}    ${expected_success}
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-title')]    timeout=30s
    ${title}=    Get Text    xpath=//div[contains(@class, 'swal-title')]
    Should Contain    ${title}    ${expected_title}
    ${text}=     Get Text    xpath=//div[contains(@class, 'swal-text')]
    Should Contain    ${text}    ${expected_text}    # ปรับให้ตรงกับข้อความจริง
    Click Element    xpath=//button[contains(@class, 'swal-button--cancel')]
    Reload Page
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'card-header')]    timeout=15s

Logout And Close Browser
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=15s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/logout')]    timeout=15s
    Click Element    xpath=//a[contains(@href, '/logout')]
    Wait Until Location Contains    ${LOGIN_URL}    timeout=15s
    Log To Console    Logged out successfully
    Close Browser

*** Test Cases ***
TC43_ADMINPermission - ตรวจสอบภาษาส่วนต่างๆ ของ UI20
    [Setup]    Reset Language To English
    Go To    ${PERMISSIONS_URL}
    Verify Page Language    Permission    New Permission
    Verify New Permission Button    New Permission
    Switch Language    th
    Go To    ${PERMISSIONS_URL}
    Verify Page Language    สิทธิ์การเข้าถึง    สร้างสิทธิ์ใหม่
    Verify New Permission Button    สร้างสิทธิ์ใหม่
    Switch Language    zh
    Go To    ${PERMISSIONS_URL}
    Verify Page Language    权限    创建新权限
    Verify New Permission Button    创建新权限

TC42_ADMINPermission_TableTranslation - ตรวจสอบภาษาในตารางของ UI20
    [Setup]    Reset Language To English
    Go To    ${PERMISSIONS_URL}
    # ตรวจสอบคอลัมน์ 1
    ${status1}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table//thead//tr//th[1]    timeout=40s
    Run Keyword If    not ${status1}    Log To Console    Element not found for header 1 after 40s
    ${text1}=    Get Text    xpath=//table//thead//tr//th[1]
    Log To Console    Actual text for header 1: ${text1}
    Run Keyword If    "${text1}" != "#"    Fail    Header 1 mismatch: Expected "#", got "${text1}"
    Log To Console    Successfully verified header 1: Expected "#", Actual "${text1}"

    # ตรวจสอบคอลัมน์ 2
    ${status2}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table//thead//tr//th[2]    timeout=40s
    Run Keyword If    not ${status2}    Log To Console    Element not found for header 2 after 40s
    ${text2}=    Get Text    xpath=//table//thead//tr//th[2]
    Log To Console    Actual text for header 2: ${text2}
    Run Keyword If    "${text2}" != "Permission Name"    Fail    Header 2 mismatch: Expected "Permission Name", got "${text2}"
    Log To Console    Successfully verified header 2: Expected "Permission Name", Actual "${text2}"

    # ตรวจสอบคอลัมน์ 3
    ${status3}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table//thead//tr//th[3]    timeout=40s
    Run Keyword If    not ${status3}    Log To Console    Element not found for header 3 after 40s
    ${text3}=    Get Text    xpath=//table//thead//tr//th[3]
    Log To Console    Actual text for header 3: ${text3}
    Run Keyword If    "${text3}" != "Actions"    Fail    Header 3 mismatch: Expected "Actions", got "${text3}"
    Log To Console    Successfully verified header 3: Expected "Actions", Actual "${text3}"

    Switch Language    th
    Go To    ${PERMISSIONS_URL}
    # ตรวจสอบคอลัมน์ 1
    ${status1}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table//thead//tr//th[1]    timeout=40s
    Run Keyword If    not ${status1}    Log To Console    Element not found for header 1 after 40s
    ${text1}=    Get Text    xpath=//table//thead//tr//th[1]
    Log To Console    Actual text for header 1: ${text1}
    Run Keyword If    "${text1}" != "#"    Fail    Header 1 mismatch: Expected "#", got "${text1}"
    Log To Console    Successfully verified header 1: Expected "#", Actual "${text1}"

    # ตรวจสอบคอลัมน์ 2
    ${status2}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table//thead//tr//th[2]    timeout=40s
    Run Keyword If    not ${status2}    Log To Console    Element not found for header 2 after 40s
    ${text2}=    Get Text    xpath=//table//thead//tr//th[2]
    Log To Console    Actual text for header 2: ${text2}
    Run Keyword If    "${text2}" != "ชื่อสิทธิ์"    Fail    Header 2 mismatch: Expected "ชื่อสิทธิ์", got "${text2}"
    Log To Console    Successfully verified header 2: Expected "ชื่อสิทธิ์", Actual "${text2}"

    # ตรวจสอบคอลัมน์ 3
    ${status3}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table//thead//tr//th[3]    timeout=40s
    Run Keyword If    not ${status3}    Log To Console    Element not found for header 3 after 40s
    ${text3}=    Get Text    xpath=//table//thead//tr//th[3]
    Log To Console    Actual text for header 3: ${text3}
    Run Keyword If    "${text3}" != "การกระทำ"    Fail    Header 3 mismatch: Expected "การกระทำ", got "${text3}"
    Log To Console    Successfully verified header 3: Expected "การกระทำ", Actual "${text3}"

    Switch Language    zh
    Go To    ${PERMISSIONS_URL}
    # ตรวจสอบคอลัมน์ 1
    ${status1}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table//thead//tr//th[1]    timeout=40s
    Run Keyword If    not ${status1}    Log To Console    Element not found for header 1 after 40s
    ${text1}=    Get Text    xpath=//table//thead//tr//th[1]
    Log To Console    Actual text for header 1: ${text1}
    Run Keyword If    "${text1}" != "#"    Fail    Header 1 mismatch: Expected "#", got "${text1}"
    Log To Console    Successfully verified header 1: Expected "#", Actual "${text1}"

    # ตรวจสอบคอลัมน์ 2
    ${status2}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table//thead//tr//th[2]    timeout=40s
    Run Keyword If    not ${status2}    Log To Console    Element not found for header 2 after 40s
    ${text2}=    Get Text    xpath=//table//thead//tr//th[2]
    Log To Console    Actual text for header 2: ${text2}
    Run Keyword If    "${text2}" != "权限名称"    Fail    Header 2 mismatch: Expected "权限名称", got "${text2}"
    Log To Console    Successfully verified header 2: Expected "权限名称", Actual "${text2}"

    # ตรวจสอบคอลัมน์ 3
    ${status3}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table//thead//tr//th[3]    timeout=40s
    Run Keyword If    not ${status3}    Log To Console    Element not found for header 3 after 40s
    ${text3}=    Get Text    xpath=//table//thead//tr//th[3]
    Log To Console    Actual text for header 3: ${text3}
    Run Keyword If    "${text3}" != "操作"    Fail    Header 3 mismatch: Expected "操作", got "${text3}"
    Log To Console    Successfully verified header 3: Expected "操作", Actual "${text3}"

TC40_ADMINPermission_FormTranslation - ตรวจสอบภาษาของฟอร์มเพิ่ม Permissions ของ UI20
    [Setup]    Reset Language To English
    Go To    ${CREATE_URL}
    Verify Page Language    Create Permission
    Verify Page Language    Permissions List
    Verify Button Text    Save
    Switch Language    th
    Go To    ${CREATE_URL}
    Verify Page Language    สร้างสิทธิ์การเข้าถึง
    Verify Page Language    รายการสิทธิ์การเข้าถึง
    Verify Button Text    บันทึก
    Switch Language    zh
    Go To    ${CREATE_URL}
    Verify Page Language    创建权限
    Verify Page Language    权限列表
    Verify Button Text    保存

TC41_ADMINPermission_ViewTranslation - ตรวจสอบภาษาดูข้อมูล action view ของ UI20
    [Setup]    Reset Language To English
    Go To    ${VIEW_URL}
    Verify Page Language    Permission
    Verify Page Language    Back
    Switch Language    th
    Go To    ${VIEW_URL}
    Verify Page Language    สิทธิ์การเข้าถึง
    Verify Page Language    ย้อนกลับ
    Switch Language    zh
    Go To    ${VIEW_URL}
    Verify Page Language    权限
    Verify Page Language    返回

TC44_ADMINPermission_EditTranslation - ตรวจสอบภาษา form action Edit ของ UI20
    [Setup]    Reset Language To English
    Go To    ${EDIT_URL}
    Verify Page Language    Edit Permission
    Verify Page Language    Permissions List
    Verify Button Text    Save
    Switch Language    th
    Go To    ${EDIT_URL}
    Verify Page Language    แก้ไขสิทธิ์การเข้าถึง
    Verify Page Language    รายการสิทธิ์การเข้าถึง
    Verify Button Text    บันทึก
    Switch Language    zh
    Go To    ${EDIT_URL}
    Verify Page Language    编辑权限
    Verify Page Language    权限列表
    Verify Button Text    保存

TC45_ADMINPermission_DeleteTranslation - ตรวจสอบภาษาการลบข้อมูล และ pop up ที่แสดงขึ้นมา ของ UI20
    [Setup]    Reset Language To English
    Go To    ${PERMISSIONS_URL}
    Log To Console    Starting deletion test in English...

    # ตรวจสอบและคลิกปุ่มลบแรก
    ${delete_button_status}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//button[contains(@class, 'show_confirm')][1]    timeout=15s
    Run Keyword If    not ${delete_button_status}    Fail    Delete button not found
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Log To Console    Clicked delete button

    # ตรวจสอบข้อความใน Popup
    ${popup_title_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-title')]    timeout=15s
    Run Keyword If    not ${popup_title_status}    Fail    Popup title not found
    ${popup_title}=    Get Text    xpath=//div[contains(@class, 'swal-title')]
    Run Keyword If    "${popup_title}" != "Are you sure?"    Fail    Popup title mismatch: Expected "Are you sure?", got "${popup_title}"
    Log To Console    Popup title: ${popup_title}

    ${popup_text_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-text')]    timeout=15s
    Run Keyword If    not ${popup_text_status}    Fail    Popup text not found
    ${popup_text}=    Get Text    xpath=//div[contains(@class, 'swal-text')]
    Run Keyword If    "${popup_text}" != "You will not be able to recover this file!"    Fail    Popup text mismatch: Expected "You will not be able to recover this file!", got "${popup_text}"
    Log To Console    Popup text: ${popup_text}

    # ตรวจสอบปุ่ม Cancel และ OK
    ${cancel_button_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//button[contains(text(), 'Cancel')]    timeout=15s
    Run Keyword If    not ${cancel_button_status}    Fail    Cancel button not found
    ${ok_button_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//button[contains(text(), 'OK')]    timeout=15s
    Run Keyword If    not ${ok_button_status}    Fail    OK button not found
    Log To Console    Verified Cancel and OK buttons

    # คลิกยกเลิกเพื่อปิด Popup
    Click Element    xpath=//button[contains(text(), 'Cancel')]
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'card-header')]    timeout=15s
    Log To Console    Cancelled deletion, returned to page

    Switch Language    th
    Go To    ${PERMISSIONS_URL}
    Log To Console    Starting deletion test in Thai...

    # ตรวจสอบและคลิกปุ่มลบแรก
    ${delete_button_status}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//button[contains(@class, 'show_confirm')][1]    timeout=15s
    Run Keyword If    not ${delete_button_status}    Fail    Delete button not found
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Log To Console    Clicked delete button

    # ตรวจสอบข้อความใน Popup
    ${popup_title_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-title')]    timeout=15s
    Run Keyword If    not ${popup_title_status}    Fail    Popup title not found
    ${popup_title}=    Get Text    xpath=//div[contains(@class, 'swal-title')]
    Run Keyword If    "${popup_title}" != "คุณแน่ใจหรือไม่?"    Fail    Popup title mismatch: Expected "คุณแน่ใจหรือไม่?", got "${popup_title}"
    Log To Console    Popup title: ${popup_title}

    ${popup_text_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-text')]    timeout=15s
    Run Keyword If    not ${popup_text_status}    Fail    Popup text not found
    ${popup_text}=    Get Text    xpath=//div[contains(@class, 'swal-text')]
    Run Keyword If    "${popup_text}" != "หากคุณลบข้อมูลนี้ จะไม่สามารถกู้คืนได้"    Fail    Popup text mismatch: Expected "หากคุณลบข้อมูลนี้ จะไม่สามารถกู้คืนได้", got "${popup_text}"
    Log To Console    Popup text: ${popup_text}

    # ตรวจสอบปุ่ม Cancel และ OK
    ${cancel_button_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//button[contains(text(), 'ยกเลิก')]    timeout=15s
    Run Keyword If    not ${cancel_button_status}    Fail    Cancel button not found
    ${ok_button_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//button[contains(text(), 'ตกลง')]    timeout=15s
    Run Keyword If    not ${ok_button_status}    Fail    OK button not found
    Log To Console    Verified Cancel and OK buttons

    # คลิกยกเลิกเพื่อปิด Popup
    Click Element    xpath=//button[contains(text(), 'ยกเลิก')]
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'card-header')]    timeout=15s
    Log To Console    Cancelled deletion, returned to page

    Switch Language    zh
    Go To    ${PERMISSIONS_URL}
    Log To Console    Starting deletion test in Chinese...

    # ตรวจสอบและคลิกปุ่มลบแรก
    ${delete_button_status}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//button[contains(@class, 'show_confirm')][1]    timeout=15s
    Run Keyword If    not ${delete_button_status}    Fail    Delete button not found
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Log To Console    Clicked delete button

    # ตรวจสอบข้อความใน Popup
    ${popup_title_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-title')]    timeout=15s
    Run Keyword If    not ${popup_title_status}    Fail    Popup title not found
    ${popup_title}=    Get Text    xpath=//div[contains(@class, 'swal-title')]
    Run Keyword If    "${popup_title}" != "你确定吗？"    Fail    Popup title mismatch: Expected "你确定吗？", got "${popup_title}"
    Log To Console    Popup title: ${popup_title}

    ${popup_text_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-text')]    timeout=15s
    Run Keyword If    not ${popup_text_status}    Fail    Popup text not found
    ${popup_text}=    Get Text    xpath=//div[contains(@class, 'swal-text')]
    Run Keyword If    "${popup_text}" != "如果删除，数据将永远消失。"    Fail    Popup text mismatch: Expected "如果删除，数据将永远消失。", got "${popup_text}"
    Log To Console    Popup text: ${popup_text}

    # ตรวจสอบปุ่ม Cancel และ OK
    ${cancel_button_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//button[contains(text(), '取消')]    timeout=15s
    Run Keyword If    not ${cancel_button_status}    Fail    Cancel button not found
    ${ok_button_status}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath=//button[contains(text(), '确定')]    timeout=15s
    Run Keyword If    not ${ok_button_status}    Fail    OK button not found
    Log To Console    Verified Cancel and OK buttons

    # คลิกยกเลิกเพื่อปิด Popup
    Click Element    xpath=//button[contains(text(), '取消')]
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'card-header')]    timeout=15s
    Log To Console    Cancelled deletion, returned to page

