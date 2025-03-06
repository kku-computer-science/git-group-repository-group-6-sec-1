*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser And Login
Suite Teardown  Logout And Close Browser

*** Variables ***
${BROWSER}              Firefox
${DEPARTMENTS_URL}      http://127.0.0.1:8000/departments
${USERNAME}             admin@gmail.com
${PASSWORD}             12345678
${LOGIN_URL}            http://127.0.0.1:8000/login
${DASHBOARD_URL}        http://127.0.0.1:8000/dashboard

*** Keywords ***
Open Browser And Login
    Open Browser    ${LOGIN_URL}    ${BROWSER}
    Maximize Browser Window
    Login To System

Login To System
    Wait Until Element Is Visible    id=username    timeout=20s
    Input Text    id=username    ${USERNAME}
    Input Text    id=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit']
    Wait Until Location Contains    ${DASHBOARD_URL}    timeout=20s
    Log To Console    Login successful, redirected to: ${DASHBOARD_URL}

Reset Language To English
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=20s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    ${english_present}=    Run Keyword And Return Status    Element Should Be Visible    xpath=//a[contains(., 'English')]
    Run Keyword If    not ${english_present}    Fail    English language option not found
    Click Element    xpath=//a[contains(., 'English')]
    Wait Until Element Is Visible    xpath=//span[contains(@class, 'flag-icon-us')]    timeout=15s
    Wait Until Page Contains    Research Information Management System    timeout=20s
    Log To Console    Reset language to English

Switch Language
    [Arguments]    ${lang}
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=20s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    Click Element    xpath=//a[contains(@href, '/lang/${lang}')]
    ${flag}=    Run Keyword If    '${lang}' == 'zh'    Set Variable    cn    ELSE    Set Variable    ${lang}
    Wait Until Element Is Visible    xpath=//span[contains(@class, 'flag-icon-${flag}')]    timeout=15s
    Run Keyword If    '${lang}' == 'en'    Wait Until Page Contains    Research Information Management System    timeout=20s
    Run Keyword If    '${lang}' == 'th'    Wait Until Page Contains    ระบบจัดการข้อมูลวิจัย    timeout=20s
    Run Keyword If    '${lang}' == 'zh'    Wait Until Page Contains    研究信息管理系统    timeout=20s
    Log To Console    Switched to language: ${lang}

Logout And Close Browser
    Go To    ${DASHBOARD_URL}
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]    timeout=20s
    Click Element    xpath=//a[contains(@class, 'nav-link dropdown-toggle')]
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/logout')]    timeout=20s
    Click Element    xpath=//a[contains(@href, '/logout')]
    Wait Until Location Contains    ${LOGIN_URL}    timeout=20s
    Log To Console    Logged out successfully
    Close Browser

*** Test Cases ***
TC42_ADMINDepartments_TableTranslation - ตรวจสอบภาษาในตารางของ UI21
    [Setup]    Reset Language To English
    Go To    ${DEPARTMENTS_URL}
    Log To Console    Starting verification of English table headers...

    # ตรวจสอบคอลัมน์ 1
    ${status1}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[1]    timeout=40s
    Run Keyword If    not ${status1}    Log To Console    Element not found for header 1 after 40s
    ${text1}=    Get Text    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[1]
    Log To Console    Actual text for header 1: ${text1}
    Run Keyword If    "${text1}" != "#"    Fail    Header 1 mismatch: Expected "#", got "${text1}"
    Log To Console    Successfully verified header 1: Expected "#", Actual "${text1}"

    # ตรวจสอบคอลัมน์ 2
    ${status2}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[2]    timeout=40s
    Run Keyword If    not ${status2}    Log To Console    Element not found for header 2 after 40s
    ${text2}=    Get Text    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[2]
    Log To Console    Actual text for header 2: ${text2}
    Run Keyword If    "${text2}" != "Department Name"    Fail    Header 2 mismatch: Expected "Department Name", got "${text2}"
    Log To Console    Successfully verified header 2: Expected "Department Name", Actual "${text2}"

    # ตรวจสอบคอลัมน์ 3
    ${status3}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[3]    timeout=40s
    Run Keyword If    not ${status3}    Log To Console    Element not found for header 3 after 40s
    ${text3}=    Get Text    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[3]
    Log To Console    Actual text for header 3: ${text3}
    Run Keyword If    "${text3}" != "Action"    Fail    Header 3 mismatch: Expected "Action", got "${text3}"
    Log To Console    Successfully verified header 3: Expected "Action", Actual "${text3}"

    Switch Language    th
    Go To    ${DEPARTMENTS_URL}
    Log To Console    Starting verification of Thai table headers...

    # ตรวจสอบคอลัมน์ 1
    ${status1}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[1]    timeout=40s
    Run Keyword If    not ${status1}    Log To Console    Element not found for header 1 after 40s
    ${text1}=    Get Text    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[1]
    Log To Console    Actual text for header 1: ${text1}
    Run Keyword If    "${text1}" != "#"    Fail    Header 1 mismatch: Expected "#", got "${text1}"
    Log To Console    Successfully verified header 1: Expected "#", Actual "${text1}"

    # ตรวจสอบคอลัมน์ 2
    ${status2}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[2]    timeout=40s
    Run Keyword If    not ${status2}    Log To Console    Element not found for header 2 after 40s
    ${text2}=    Get Text    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[2]
    Log To Console    Actual text for header 2: ${text2}
    Run Keyword If    "${text2}" != "ชื่อแผนก"    Fail    Header 2 mismatch: Expected "ชื่อแผนก", got "${text2}"
    Log To Console    Successfully verified header 2: Expected "ชื่อแผนก", Actual "${text2}"

    # ตรวจสอบคอลัมน์ 3
    ${status3}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[3]    timeout=40s
    Run Keyword If    not ${status3}    Log To Console    Element not found for header 3 after 40s
    ${text3}=    Get Text    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[3]
    Log To Console    Actual text for header 3: ${text3}
    Run Keyword If    "${text3}" != "การกระทำ"    Fail    Header 3 mismatch: Expected "การกระทำ", got "${text3}"
    Log To Console    Successfully verified header 3: Expected "การกระทำ", Actual "${text3}"

    Switch Language    zh
    Go To    ${DEPARTMENTS_URL}
    Log To Console    Starting verification of Chinese table headers...

    # ตรวจสอบคอลัมน์ 1
    ${status1}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[1]    timeout=40s
    Run Keyword If    not ${status1}    Log To Console    Element not found for header 1 after 40s
    ${text1}=    Get Text    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[1]
    Log To Console    Actual text for header 1: ${text1}
    Run Keyword If    "${text1}" != "#"    Fail    Header 1 mismatch: Expected "#", got "${text1}"
    Log To Console    Successfully verified header 1: Expected "#", Actual "${text1}"

    # ตรวจสอบคอลัมน์ 2
    ${status2}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[2]    timeout=40s
    Run Keyword If    not ${status2}    Log To Console    Element not found for header 2 after 40s
    ${text2}=    Get Text    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[2]
    Log To Console    Actual text for header 2: ${text2}
    Run Keyword If    "${text2}" != "部门名称"    Fail    Header 2 mismatch: Expected "部门名称", got "${text2}"
    Log To Console    Successfully verified header 2: Expected "部门名称", Actual "${text2}"

    # ตรวจสอบคอลัมน์ 3
    ${status3}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[3]    timeout=40s
    Run Keyword If    not ${status3}    Log To Console    Element not found for header 3 after 40s
    ${text3}=    Get Text    xpath=//table[contains(@class, 'table-hover')]//thead//tr//th[3]
    Log To Console    Actual text for header 3: ${text3}
    Run Keyword If    "${text3}" != "操作"    Fail    Header 3 mismatch: Expected "操作", got "${text3}"
    Log To Console    Successfully verified header 3: Expected "操作", Actual "${text3}"