*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              Firefox
${PERMISSIONS_URL}      http://127.0.0.1:8000/permissions
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
    [Arguments]    ${expected_title}    ${expected_new_button}
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'card-header')]    timeout=15s
    ${actual_text}=    Get Text    xpath=//div[contains(@class, 'card-header')]
    Log To Console    Actual card header text: ${actual_text}
    Should Contain    ${actual_text}    ${expected_title}
    Should Contain    ${actual_text}    ${expected_new_button}
    Log To Console    Verified title: ${expected_title}, new button: ${expected_new_button}

Verify New Permission Button
    [Arguments]    ${expected_text}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'btn btn-primary')]    timeout=15s
    ${actual_text}=    Get Text    xpath=//a[contains(@class, 'btn btn-primary')]
    Should Contain    ${actual_text}    ${expected_text}
    Log To Console    Verified new permission button text: ${expected_text}

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