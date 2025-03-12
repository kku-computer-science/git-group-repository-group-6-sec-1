*** Settings ***
Documentation    Test Suite for User Manage Funds System
Library          SeleniumLibrary
Suite Setup      Open Browser And Login
Suite Teardown   Close All Browsers

*** Variables ***
${BASE_URL}       https://cs6sec267.cpkkuhost.com
${LOGIN_URL}      ${BASE_URL}/login
${FUNDS_URL}      ${BASE_URL}/funds
${CREATE_URL}     ${BASE_URL}/funds/create
${VIEW_URL}       ${BASE_URL}/funds/2
${EDIT_URL}       ${BASE_URL}/funds/eyJpdiI6InB6WTNiaDQ0VnJrMHFnQVF5bW1ERFE9PSIsInZhbHVlIjoiVVVnSHNVYjBveVVUUWZHRkc0VUQ4UT09IiwibWFjIjoiNDg0YjNmMzI5MzVmZjFlMjY2MGE2ZjI0MDNkZmUzY2JjYzY3MjcyZGU1ZDEyZDA0NmRlZWJiMzU4Zjg4MWFiYyIsInRhZyI6IiJ9/edit
${BROWSER}        chrome
${USERNAME}       pusadee@kku.ac.th
${PASSWORD}       123456789

*** Test Cases ***
TC01 - Login and Access Funds List
    [Documentation]    Verify successful login and navigation to funds page
    Wait For Table Load
    Page Should Contain Element    xpath://table[@id='example1']
    Page Should Contain    Research Funds  # เปลี่ยนจาก Fund Management เป็น Research Funds

TC02 - Verify Funds List Display
    [Documentation]    Verify the funds table displays correctly
    Wait For Table Load
    ${count}=    Get Fund Count
    Should Be True    ${count} >= 0
    Page Should Contain Element    xpath://th[contains(text(),'No')]
    Page Should Contain Element    xpath://th[contains(text(),'Fund Name')]
    Page Should Contain Element    xpath://th[contains(text(),'Fund Type')]
    Page Should Contain Element    xpath://th[contains(text(),'Fund Level')]
    Page Should Contain Element    xpath://th[contains(text(),'Action')]

TC03 - Add New Fund
    [Documentation]    Verify adding a new fund
    Go To    ${CREATE_URL}
    Wait For Page Load
    Fill Fund Form    ทุนวิจัยใหม่    ทุนภายใน    สูง    Resource Test
    Click Element    xpath://button[@type='submit']
    Wait Until Page Contains    success    timeout=10s
    ${current_url}=    Get Location
    Run Keyword If    '${current_url}' != '${FUNDS_URL}'    Go To    ${FUNDS_URL}
    Reload Page
    Wait For Table Load
    Search In DataTable    ทุนวิจัยใหม่
    Page Should Contain    ทุนวิจัยใหม่

TC04 - View Fund Details
    [Documentation]    Verify viewing details of a fund
    Go To    ${FUNDS_URL}
    Wait For Table Load
    Search In DataTable    ทุนวิจัยใหม่
    ${row}=    Get Element Count    xpath://table[@id='example1']/tbody/tr[td[contains(text(),'ทุนวิจัยใหม่')]]
    Run Keyword If    ${row} > 0    Click View Button By Text    ทุนวิจัยใหม่
    ...    ELSE    Fail    Fund 'ทุนวิจัยใหม่' not found in table after search
    Wait For Page Load
    Page Should Contain Element    xpath://h4[contains(text(),'Research Funds')]  # ปรับตาม TC01
    Page Should Contain    ทุนวิจัยใหม่
    Click Element    xpath://a[contains(text(),'Back') or contains(text(),'กลับ')]
    Wait For Table Load

TC05 - Edit Fund
    [Documentation]    Verify editing an existing fund
    Go To    ${FUNDS_URL}
    Wait For Table Load
    ${initial_count}=    Get Fund Count
    Search In DataTable    ทุนวิจัยใหม่
    ${row}=    Get Element Count    xpath://table[@id='example1']/tbody/tr[td[contains(text(),'ทุนวิจัยใหม่')]]
    Run Keyword If    ${row} > 0    Click Edit Button By Text    ทุนวิจัยใหม่
    ...    ELSE    Fail    Fund 'ทุนวิจัยใหม่' not found in table after search
    Wait For Page Load
    Fill Fund Form    ทุนวิจัยใหม่ที่แก้ไข    ทุนภายนอก    ${EMPTY}    Updated Resource
    Click Element    xpath://button[@type='submit']
    Wait Until Page Contains    Fund updated successfully    timeout=10s
    Go To    ${FUNDS_URL}
    Reload Page
    Wait For Table Load
    ${new_count}=    Get Fund Count
    Search In DataTable    ทุนวิจัยใหม่ที่แก้ไข
    Page Should Contain    ทุนวิจัยใหม่ที่แก้ไข
    Should Be Equal    ${initial_count}    ${new_count}

TC06 - Delete Fund
    [Documentation]    Verify deleting a fund
    Go To    ${FUNDS_URL}
    Wait For Table Load
    Search In DataTable    ทุนวิจัยใหม่ที่แก้ไข
    ${row}=    Get Element Count    xpath://table[@id='example1']/tbody/tr[td[contains(text(),'ทุนวิจัยใหม่ที่แก้ไข')]]
    Run Keyword If    ${row} > 0    Click Delete Button By Text    ทุนวิจัยใหม่ที่แก้ไข
    ...    ELSE    Fail    Fund 'ทุนวิจัยใหม่ที่แก้ไข' not found in table after search
    Handle Sweet Alert Confirmation
    Sleep    2s
    Reload Page
    Wait For Table Load
    Search In DataTable    ทุนวิจัยใหม่ที่แก้ไข
    Page Should Not Contain    ทุนวิจัยใหม่ที่แก้ไข

*** Keywords ***
Open Browser And Login
    Open Browser    ${LOGIN_URL}    ${BROWSER}
    Maximize Browser Window
    Login To System
    ${current_url}=    Get Location
    Run Keyword If    '${current_url}' != '${FUNDS_URL}'    Go To    ${FUNDS_URL}
    Wait Until Page Contains Element    xpath://table[@id='example1']    timeout=10s

Login To System
    Wait Until Page Contains Element    id=username    timeout=10s
    Input Text    id=username    ${USERNAME}
    Input Text    id=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit']
    ${status}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath://body    timeout=10s
    Run Keyword If    not ${status}    Fail    Login failed or initial page not loaded

Wait For Page Load
    [Arguments]    ${timeout}=10s
    Wait Until Page Contains Element    xpath://body    timeout=${timeout}

Wait For Table Load
    [Arguments]    ${timeout}=10s
    Wait Until Page Contains Element    xpath://table[@id='example1']    timeout=${timeout}

Handle Sweet Alert Confirmation
    Wait Until Page Contains Element    xpath://div[contains(@class,'swal-modal')]    timeout=10s
    Click Element    xpath://button[contains(@class,'swal-button--confirm')]  # คลิก Confirm ครั้งแรก
    Wait Until Page Contains    success    timeout=10s  # รอ Sweet Alert Success
    Click Element    xpath://button[contains(@class,'swal-button--confirm')]  # คลิก Confirm ครั้งที่สอง
    Wait Until Element Is Not Visible    xpath://div[contains(@class,'swal-modal')]    timeout=10s

Search In DataTable
    [Arguments]    ${search_text}
    Wait Until Element Is Visible    xpath://div[@id='example1_filter']//input[@type='search']    timeout=10s
    Input Text    xpath://div[@id='example1_filter']//input[@type='search']    ${search_text}
    Sleep    3s
    Wait Until Page Contains Element    xpath://table[@id='example1']/tbody/tr    timeout=10s

Click View Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table[@id='example1']/tbody/tr[td[contains(text(),'${text}')]]//a[contains(@href,'/funds/') and @title='View']
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Click Edit Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table[@id='example1']/tbody/tr[td[contains(text(),'${text}')]]//a[contains(@href,'funds/edit') or contains(@title,'Edit')]
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Click Delete Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table[@id='example1']/tbody/tr[td[contains(text(),'${text}')]][1]//button[contains(@class,'show_confirm') or contains(@title,'Delete')]
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Get Fund Count
    ${count}=    Get Element Count    xpath://table[@id='example1']/tbody/tr
    RETURN    ${count}

Fill Fund Form
    [Arguments]    ${fund_name}    ${fund_type}    ${fund_level}    ${support_resource}
    Input Text    name=fund_name    ${fund_name}
    Select From List By Value    name=fund_type    ${fund_type}
    Run Keyword If    '${fund_type}' == 'ทุนภายใน'    Select From List By Value    name=fund_level    ${fund_level}
    Input Text    name=support_resource    ${support_resource}
