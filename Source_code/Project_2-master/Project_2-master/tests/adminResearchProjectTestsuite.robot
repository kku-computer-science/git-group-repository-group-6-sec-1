*** Settings ***
Documentation    Test Suite for Research Projects System
Library          SeleniumLibrary
Suite Setup      Open Browser And Login
Suite Teardown   Close All Browsers

*** Variables ***
${LOGIN_URL}      http://127.0.0.1:8000/login
${RESEARCH_URL}   http://127.0.0.1:8000/researchProjects
${BROWSER}        chrome
${USERNAME}       admin@gmail.com
${PASSWORD}       12345678
${CREATE_URL}     http://127.0.0.1:8000/researchProjects/create
${VIEW_URL}       http://127.0.0.1:8000/researchProjects/20
${EDIT_URL}       http://127.0.0.1:8000/researchProjects/20/edit

*** Test Cases ***
TC01 - Login and Access Research Projects List
    [Documentation]    Verify successful login and navigation to research projects page
    Wait For Table Load
    Page Should Contain Element    xpath://table[@id='example1']
    Page Should Contain    Research Projects

TC02 - Verify Research Projects List Display
    [Documentation]    Verify the research projects table displays correctly
    Wait For Table Load
    ${count}=    Get Project Count
    Should Be True    ${count} >= 0
    Page Should Contain Element    xpath://th[contains(text(),'No')]
    Page Should Contain Element    xpath://th[contains(text(),'Year')]
    Page Should Contain Element    xpath://th[contains(text(),'Project Name')]
    Page Should Contain Element    xpath://th[contains(text(),'Head')]
    Page Should Contain Element    xpath://th[contains(text(),'Member')]
    Page Should Contain Element    xpath://th[contains(text(),'Action')]

TC03 - Add New Research Project
    [Documentation]    Verify adding a new research project
    Go To    ${CREATE_URL}
    Wait For Page Load
    Fill Project Form    Test Project    2025-03-01    2025-12-31    2025    100000    Test Note
    Scroll Element Into View    xpath://button[@type='submit']
    Click Element    xpath://button[@type='submit']
    Wait Until Page Contains    success    timeout=10s
    ${current_url}=    Get Location
    Run Keyword If    '${current_url}' != '${RESEARCH_URL}'    Go To    ${RESEARCH_URL}
    Reload Page
    Wait For Table Load
    Search In DataTable    Test Project
    Page Should Contain    Test Project

TC04 - View Research Project Details
    [Documentation]    Verify viewing details of a research project
    Go To    ${RESEARCH_URL}
    Wait For Table Load
    Search In DataTable    Test Project
    ${row}=    Get Element Count    xpath://table[@id='example1']/tbody/tr[td[contains(text(),'Test Project')]]
    Run Keyword If    ${row} > 0    Click View Button By Text    Test Project
    ...    ELSE    Fail    Test Project not found in table after search
    Wait For Page Load
    Page Should Contain Element    xpath://h4[contains(text(),'Research Projects')]
    Page Should Contain    Test Project
    Click Element    xpath://a[contains(text(),'Back') or contains(text(),'กลับ')]
    Wait For Table Load

TC05 - Edit Research Project
    [Documentation]    Verify editing an existing research project
    Go To    ${RESEARCH_URL}
    Wait For Table Load
    ${initial_count}=    Get Project Count
    Search In DataTable    Test Project
    ${row}=    Get Element Count    xpath://table[@id='example1']/tbody/tr[td[contains(text(),'Test Project')]]
    Run Keyword If    ${row} > 0    Click Edit Button By Text    Test Project
    ...    ELSE    Fail    Test Project not found in table after search
    Wait For Page Load
    Fill Project Form    Updated Project    2025-04-01    2025-11-30    2025    150000    Updated Note
    Scroll Element Into View    xpath://button[@type='submit']
    Click Element    xpath://button[@type='submit']
    Wait Until Page Contains    success    timeout=10s
    Go To    ${RESEARCH_URL}
    Reload Page
    Wait For Table Load
    ${new_count}=    Get Project Count    # นับก่อนกรองข้อมูล
    Search In DataTable    Updated Project
    Page Should Contain    Updated Project
    Should Be Equal    ${initial_count}    ${new_count}

TC06 - Delete Research Project
    [Documentation]    Verify deleting a research project without checking row counts
    Go To    ${RESEARCH_URL}
    Wait For Table Load
    Search In DataTable    Updated Project
    ${row}=    Get Element Count    xpath://table[@id='example1']/tbody/tr[td[contains(text(),'Updated Project')]]
    Run Keyword If    ${row} > 0    Click Delete Button By Text    Updated Project
    ...    ELSE    Fail    Updated Project not found in table after search
    Handle Sweet Alert Confirmation
    Sleep    2s
    Reload Page
    Wait For Table Load
    Search In DataTable    Updated Project
    Page Should Not Contain    Updated Project

*** Keywords ***
Clear Search Field
    Wait Until Element Is Visible    xpath://div[@id='example1_filter']//input[@type='search']    timeout=10s
    Input Text    xpath://div[@id='example1_filter']//input[@type='search']    ${EMPTY}
    Sleep    2s    # รอตารางรีเฟรช
    Wait Until Page Contains Element    xpath://table[@id='example1']/tbody/tr    timeout=10s

*** Keywords ***
Open Browser And Login
    Open Browser    ${LOGIN_URL}    ${BROWSER}
    Maximize Browser Window
    Login To System
    ${current_url}=    Get Location
    Run Keyword If    '${current_url}' != '${RESEARCH_URL}'    Go To    ${RESEARCH_URL}
    Wait Until Page Contains Element    xpath://table[@id='example1']    timeout=10s

Login To System
    Wait Until Page Contains Element    id=username    timeout=10s
    Log To Console    Found username field
    Input Text    id=username    ${USERNAME}
    Input Text    id=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit']
    ${status}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath://body    timeout=10s
    Run Keyword If    not ${status}    Fail    Login failed or initial page not loaded
    Log To Console    Login successful

Wait For Page Load
    [Arguments]    ${timeout}=10s
    Wait Until Page Contains Element    xpath://body    timeout=${timeout}

Wait For Table Load
    [Arguments]    ${timeout}=10s
    Wait Until Page Contains Element    xpath://table[@id='example1']    timeout=${timeout}

Handle Sweet Alert Confirmation
    Wait Until Page Contains Element    xpath://div[contains(@class,'swal-modal')]    timeout=10s
    Click Element    xpath://button[contains(@class,'swal-button--confirm')]
    Sleep    1s
    Click Element    xpath://button[contains(@class,'swal-button--confirm')]
    Wait Until Element Is Not Visible    xpath://div[contains(@class,'swal-modal')]    timeout=10s

Search In DataTable
    [Arguments]    ${search_text}
    Wait Until Element Is Visible    xpath://div[@id='example1_filter']//input[@type='search']    timeout=10s
    Input Text    xpath://div[@id='example1_filter']//input[@type='search']    ${search_text}
    Sleep    3s
    Wait Until Page Contains Element    xpath://table[@id='example1']/tbody/tr    timeout=10s

Click View Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table[@id='example1']/tbody/tr[td[contains(text(),'${text}')]]//a[contains(@href,'researchProjects/show') or contains(@title,'view')]
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Click Edit Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table[@id='example1']/tbody/tr[td[contains(text(),'${text}')]]//a[contains(@href,'researchProjects/edit') or contains(@title,'Edit')]
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Click Delete Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table[@id='example1']/tbody/tr[td[contains(text(),'${text}')]][1]//button[contains(@class,'show_confirm') or contains(@title,'Delete')]
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Get Project Count
    ${count}=    Get Element Count    xpath://table[@id='example1']/tbody/tr
    RETURN    ${count}

Fill Project Form
    [Arguments]    ${name}    ${start}    ${end}    ${year}    ${budget}    ${note}
    Input Text    name=project_name      ${name}
    Execute Javascript    document.querySelector('input[name="project_start"]').value = '${start}'
    Execute Javascript    document.querySelector('input[name="project_end"]').value = '${end}'
    ${start_value}=    Get Value    name=project_start
    Should Be Equal    ${start_value}    ${start}
    ${end_value}=    Get Value    name=project_end
    Should Be Equal    ${end_value}    ${end}
    Input Text    name=project_year      ${year}
    Input Text    name=budget            ${budget}
    Input Text    name=note              ${note}
    ${fund_options}=    Get List Items    name=fund
    Run Keyword If    ${fund_options.__len__()} > 1    Select From List By Index    name=fund    1
    ...    ELSE    Fail    No valid fund options available
    Select From List By Value    name=status    1
    ${head_options}=    Get List Items    name=head
    Run Keyword If    ${head_options.__len__()} > 1    Select From List By Index    name=head    1
    ...    ELSE    Fail    No valid head options available