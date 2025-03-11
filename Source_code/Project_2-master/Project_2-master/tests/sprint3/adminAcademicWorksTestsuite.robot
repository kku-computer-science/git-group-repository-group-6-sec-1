*** Settings ***
Documentation    Test Suite for Research Patents Management System
Library          SeleniumLibrary
Suite Setup      Open Browser And Login
Suite Teardown   Close All Browsers

*** Variables ***
${LOGIN_URL}      http://127.0.0.1:8000/login
${PATENTS_URL}    http://127.0.0.1:8000/patents
${CREATE_PATENT_URL}  http://127.0.0.1:8000/patents/create

${BROWSER}        chrome
${USERNAME}       admin@gmail.com
${PASSWORD}       12345678

# ข้อมูล Demo
${DEMO_NAME}        Smart AI System for Research Management
${DEMO_TYPE}        Patent
${DEMO_REG_DATE}    03/11/2025
${DEMO_REG_NUMBER}  12345678
${INTERNAL_AUTHOR}  Pongsathon Janyoi
${SEARCH_TERM}      smart    # คำค้นหา

*** Test Cases ***
TC01 - Add New Patent
    [Documentation]    Verify adding a new patent
    Go To    ${CREATE_PATENT_URL}
    Wait For Page Load
    Fill Patent Form    ${DEMO_NAME}    ${DEMO_TYPE}    ${DEMO_REG_DATE}    ${DEMO_REG_NUMBER}    ${INTERNAL_AUTHOR}
    Log To Console    Patent form filled successfully
    ${submit_button}=    Set Variable    xpath://button[@type='submit' and contains(@class, 'btn-primary')]
    Wait Until Element Is Visible    ${submit_button}    timeout=10s
    Log To Console    Submit button is visible
    Wait Until Element Is Enabled    ${submit_button}    timeout=10s
    Log To Console    Submit button is enabled
    Scroll Element Into View    ${submit_button}
    Log To Console    Scrolled to Submit button
    Wait For Overlay To Disappear
    Click Submit Button    ${submit_button}
    Log To Console    Submit button clicked
    # ตรวจสอบข้อความแจ้งเตือนความสำเร็จหรือข้อผิดพลาด
    ${success_message}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath://div[contains(@class, 'alert-success')]    timeout=5s
    Run Keyword If    ${success_message}    Log To Console    Success message found
    ${error_message}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath://div[contains(@class, 'alert-danger')]    timeout=5s
    Run Keyword If    ${error_message}    Run Keywords
    ...    Log To Console    Error message found, submission may have failed
    ...    AND    ${error_text}=    Get Text    xpath://div[contains(@class, 'alert-danger')]
    ...    AND    Log To Console    Error details: ${error_text}
    Run Keyword Unless    ${success_message} or ${error_message}    Log To Console    No success or error message found, checking URL
    Sleep    2s
    ${current_url}=    Get Location
    Log To Console    Current URL after submit: ${current_url}
    Run Keyword If    '${current_url}' != '${PATENTS_URL}'    Go To    ${PATENTS_URL}
    Reload Page
    Wait For Table Load
    # Debug ตาราง
    ${table_present}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath://table    timeout=10s
    Run Keyword If    ${table_present}    Log To Console    Table found on page
    Run Keyword Unless    ${table_present}    Fail    Table not found on patents page
    Search In DataTable    ${SEARCH_TERM}
    # ตรวจสอบข้อมูลในตาราง
    ${row_found}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath://table/tbody/tr[td[contains(text(), '${DEMO_NAME}')]]    timeout=10s
    Run Keyword If    ${row_found}    Log To Console    Patent '${DEMO_NAME}' found in table
    Run Keyword Unless    ${row_found}    Run Keywords
    
*** Keywords ***
Open Browser And Login
    Open Browser    ${LOGIN_URL}    ${BROWSER}
    Maximize Browser Window
    Login To System
    ${current_url}=    Get Location
    Run Keyword If    '${current_url}' != '${PATENTS_URL}'    Go To    ${PATENTS_URL}
    Wait Until Page Contains Element    xpath://table    timeout=10s

Login To System
    Wait Until Page Contains Element    id=username    timeout=10s
    Log To Console    Found username field
    Element Should Be Enabled    id=username
    Input Text    id=username    ${USERNAME}
    Wait Until Page Contains Element    id=password    timeout=10s
    Element Should Be Enabled    id=password
    Input Text    id=password    ${PASSWORD}
    Wait Until Page Contains Element    xpath://button[@type='submit']    timeout=10s
    Element Should Be Enabled    xpath://button[@type='submit']
    Click Button    xpath://button[@type='submit']
    ${status}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath://body    timeout=10s
    Run Keyword If    not ${status}    Fail    Login failed or initial page not loaded
    Log To Console    Login successful

Wait For Page Load
    [Arguments]    ${timeout}=10s
    Wait Until Page Contains Element    xpath://body    timeout=${timeout}

Wait For Table Load
    [Arguments]    ${timeout}=10s
    Wait Until Page Contains Element    xpath://table    timeout=${timeout}
    Log To Console    Table loaded successfully

Fill Patent Form
    [Arguments]    ${name}    ${type}    ${reg_date}    ${reg_number}    ${internal_author}
    ${name}=    Evaluate    '${name}'.strip()
    Wait Until Page Contains Element    name=ac_name    timeout=10s
    Element Should Be Enabled    name=ac_name
    Input Text    name=ac_name    ${name}
    Wait Until Page Contains Element    name=ac_type    timeout=10s
    Select From List By Label    name=ac_type    ${type}
    Wait Until Page Contains Element    name=ac_year    timeout=10s
    Element Should Be Enabled    name=ac_year
    Input Text    name=ac_year    ${reg_date}
    Wait Until Page Contains Element    name=ac_refnumber    timeout=10s
    Element Should Be Enabled    name=ac_refnumber
    Input Text    name=ac_refnumber    ${reg_number}
    Wait Until Page Contains Element    xpath=//button[@id='add-btn2']    timeout=10s
    Click Button    xpath=//button[@id='add-btn2']
    Wait Until Page Contains Element    xpath://select[contains(@id, 'selUser')]    timeout=10s
    Select From List By Label    xpath://select[contains(@id, 'selUser')]    ${internal_author}
    ${patent_name_value}=    Get Element Attribute    name=ac_name    value
    Should Be Equal    ${patent_name_value}    ${name}    msg=Failed to input Patent Name

Search In DataTable
    [Arguments]    ${search_text}
    ${search_field_present}=    Run Keyword And Return Status    Wait Until Element Is Visible    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    timeout=10s
    Run Keyword If    ${search_field_present}    Run Keywords
    ...    Element Should Be Enabled    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']
    ...    AND    Input Text    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    ${search_text}
    ...    AND    Sleep    3s
    ...    AND    Wait Until Page Contains Element    xpath://table/tbody/tr    timeout=10s
    Run Keyword Unless    ${search_field_present}    Log To Console    Search field not found, skipping search
    Log To Console    Searched for: ${search_text}

Wait For Overlay To Disappear
    [Arguments]    ${timeout}=10s
    ${overlay_present}=    Run Keyword And Return Status    Page Should Contain Element    xpath://*[contains(@class, 'overlay') or contains(@class, 'modal') or contains(@class, 'spinner') or contains(@class, 'swal')]    timeout=2s
    Run Keyword If    ${overlay_present}    Wait Until Keyword Succeeds    5x    1s    Element Should Not Be Visible    xpath://*[contains(@class, 'overlay') or contains(@class, 'modal') or contains(@class, 'spinner') or contains(@class, 'swal')]
    Log To Console    Overlay check completed

Click Submit Button
    [Arguments]    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Wait Until Element Is Enabled    ${locator}    timeout=10s
    Scroll Element Into View    ${locator}
    Wait For Overlay To Disappear
    ${click_status}=    Run Keyword And Return Status    Click Element    ${locator}
    Run Keyword Unless    ${click_status}    Run Keywords
    ...    Log To Console    Normal click failed, attempting JavaScript click
    ...    AND    Execute JavaScript    arguments[0].click();    ARGUMENTS    ${locator}
    Run Keyword Unless    ${click_status}    Fail    Failed to click Submit button after multiple attempts