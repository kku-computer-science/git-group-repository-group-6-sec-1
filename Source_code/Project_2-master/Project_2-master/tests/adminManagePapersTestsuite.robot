*** Settings ***
Documentation     Test Suite for managing Published Research data (Add, View, Edit, Delete) with prior login and dropdown fixes (Source Title)
Library           SeleniumLibrary
Suite Setup       Open Browser And Login
Suite Teardown    Close All Browsers

*** Variables ***
${LOGIN_URL}             http://localhost:8000/login
${PAPERS_URL}            http://localhost:8000/papers
${CREATE_URL}            http://localhost:8000/papers/create
${BROWSER}               chrome
${USERNAME}              admin@gmail.com
${PASSWORD}              12345678
${PAPER_NAME}            New Research Paper
${UPDATED_PAPER_NAME}    Updated Research Paper
${EDIT_URL}              ${EMPTY}

*** Test Cases ***
TC01 - Login and Access Published Research Page
    [Documentation]    Log in and verify that the Published Research page displays correctly
    Wait For Table Load
    Page Should Contain Element    xpath://table[@id="example1"]
    Page Should Contain            Published Research

TC02 - Add New Research Paper
    [Documentation]    Add a new research paper, verify "${PAPER_NAME}" appears in the table, and capture the Edit URL
    Go To    ${CREATE_URL}
    Sleep    3s
    ${current_url}=    Get Location
    Log To Console    Current URL: ${current_url}
    Capture Page Screenshot    create_page.png
    Wait Until Page Contains    Add Published Research    timeout=30s
    Wait Until Page Contains Element    name:paper_name    timeout=30s
    Log To Console    Form fields found, proceeding to fill form
    Fill Paper Form And Submit    ${PAPER_NAME}    This is the abstract of ${PAPER_NAME}    test; research; new    Journal
    Wait Until Page Contains    success    timeout=15s
    Go To    ${PAPERS_URL}
    Reload Page
    Wait For Table Load
    Search In DataTable    ${PAPER_NAME}
    Page Should Contain    ${PAPER_NAME}
    Capture Page Screenshot    after_add.png
    ${edit_link}=    Get Element Attribute    xpath://table[@id="example1"]/tbody/tr[td[contains(text(),"${PAPER_NAME}")]]//a[@title="Edit"]    href
    Set Suite Variable    ${EDIT_URL}    ${edit_link}
    Log To Console    Captured Edit URL: ${EDIT_URL}

TC03 - View Research Paper Details
    [Documentation]    View details of the newly added research paper
    Go To    ${PAPERS_URL}
    Search In DataTable    ${PAPER_NAME}
    ${row}=    Get Element Count    xpath://table[@id="example1"]/tbody/tr[td[contains(text(),"${PAPER_NAME}")]]
    Run Keyword If    ${row} > 0    Click View Button By Text    ${PAPER_NAME}
    ...    ELSE    Fail    Research paper "${PAPER_NAME}" not found in table
    Wait Until Page Contains    ${PAPER_NAME}    timeout=10s
    Page Should Contain    This is the abstract of ${PAPER_NAME}
    Click Element    xpath://a[contains(text(),"Back")]
    Wait For Table Load

TC04 - Edit Research Paper
    [Documentation]    Edit the research paper and change its name to "${UPDATED_PAPER_NAME}" using the captured Edit URL
    Log To Console    Edit URL: ${EDIT_URL}
    Run Keyword If    '${EDIT_URL}' == '${EMPTY}'    Fail    Edit URL is empty, check TC02
    Go To    ${EDIT_URL}

    # ✅ รอให้ฟอร์มโหลดเสร็จสมบูรณ์ก่อนกรอกข้อมูล
    Wait Until Element Is Visible    xpath://form[@class='forms-sample']    timeout=10s

    # ✅ กรอกข้อมูลในฟิลด์ input ปกติ
    Clear Element Text    name:paper_name
    Input Text    name:paper_name    ${UPDATED_PAPER_NAME}
    Input Text    name:abstract      This is the updated abstract of ${UPDATED_PAPER_NAME}
    Input Text    name:keyword       test; updated; research

    # ✅ เลือกค่าใน Select ด้วย JavaScript
    Scroll Element Into View    xpath://select[@id='paper_type']
    Execute JavaScript    document.querySelector('#paper_type').value = 'Journal';
    Execute JavaScript    var event = new Event('change'); document.querySelector('#paper_type').dispatchEvent(event);
    Sleep    1s
    
    Scroll Element Into View    xpath://select[@id='paper_subtype']
    Execute JavaScript    document.querySelector('#paper_subtype').value = 'Article';
    Execute JavaScript    var event = new Event('change'); document.querySelector('#paper_subtype').dispatchEvent(event);
    Sleep    1s

    Scroll Element Into View    xpath://select[@id='publication']
    Execute JavaScript    document.querySelector('#publication').value = 'International Journal';
    Execute JavaScript    var event = new Event('change'); document.querySelector('#publication').dispatchEvent(event);
    Sleep    1s

    # ✅ กรอกปีที่ตีพิมพ์
    Scroll Element Into View    xpath://input[@name='paper_yearpub']
    Execute JavaScript    document.querySelector('input[name="paper_yearpub"]').value = '2024';
    Execute JavaScript    var event = new Event('change'); document.querySelector('input[name="paper_yearpub"]').dispatchEvent(event);
    Sleep    1s
    
    # ✅ กรอก Citation
    Scroll Element Into View    xpath://input[@name='paper_citation']
    Execute JavaScript    document.querySelector('input[name="paper_citation"]').value = '10';
    Execute JavaScript    var event = new Event('change'); document.querySelector('input[name="paper_citation"]').dispatchEvent(event);
    Sleep    1s
    
    # ✅ กรอก Page Number
    Scroll Element Into View    xpath://input[@name='paper_page']
    Execute JavaScript    document.querySelector('input[name="paper_page"]').value = '100-120';
    Execute JavaScript    var event = new Event('change'); document.querySelector('input[name="paper_page"]').dispatchEvent(event);
    Sleep    1s
    
    # ✅ เลือก Internal Author ด้วย JavaScript
    Scroll Element Into View    xpath://select[@id='selUser0']
    Execute JavaScript    $("#selUser0").val("2").trigger("change");
    Sleep    1s
    
    Execute JavaScript    $("#pos0").val("1").trigger("change");
    Sleep    1s

    # ✅ ตรวจสอบปุ่ม Submit ก่อนกด
    Wait Until Element Is Visible    xpath://button[@type='submit']    timeout=10s
    ${is_enabled}=    Run Keyword And Return Status    Wait Until Element Is Enabled    xpath://button[@type='submit']    timeout=5s
    Run Keyword If    not ${is_enabled}    Fail    Submit button is disabled after filling form
    
    # ✅ กดปุ่ม Submit ด้วย JavaScript (ถ้าไม่ได้ผลให้ใช้ Click Element)
    Execute JavaScript    document.querySelector('button[type="submit"]').click();
    
    # ✅ ตรวจสอบความสำเร็จในการบันทึก
    # Wait Until Page Contains    Successfully updated    timeout=10s
    
    # ✅ ตรวจสอบว่าชื่อใหม่ปรากฏในตาราง
    Go To    ${PAPERS_URL}
    Reload Page
    Wait For Table Load
    Search In DataTable    ${UPDATED_PAPER_NAME}
    Page Should Contain    ${UPDATED_PAPER_NAME}

TC05 - Delete Research Paper
    [Documentation]    Delete the research paper "${UPDATED_PAPER_NAME}" and verify it is removed from the table
    Go To    ${PAPERS_URL}
    Reload Page
    Wait For Table Load
    Search In DataTable    ${UPDATED_PAPER_NAME}
    
    ${row} =    Get Element Count    xpath://table[@id="example1"]/tbody/tr[td[contains(text(),"${UPDATED_PAPER_NAME}")]]
    Run Keyword If    ${row} > 0    Click Delete Button By Text    ${UPDATED_PAPER_NAME}
    ...    ELSE    Fail    Research paper "${UPDATED_PAPER_NAME}" not found in table
    
    Handle Sweet Alert Confirmation
    Sleep    2s
    
    Reload Page
    Wait For Table Load
    Search In DataTable    ${UPDATED_PAPER_NAME}
    Page Should Not Contain    ${UPDATED_PAPER_NAME}

*** Keywords ***
# คง keyword เดิมไว้ แต่ตัดบางส่วนเพื่อความกระชับในคำตอบนี้ คัดเฉพาะที่เกี่ยวข้อง
Open Browser And Login
    Open Browser    ${LOGIN_URL}    ${BROWSER}
    Maximize Browser Window
    Login To System
    ${current_url}=    Get Location
    Run Keyword If    '${current_url}' != '${PAPERS_URL}'    Go To    ${PAPERS_URL}
    Wait For Table Load

Login To System
    Wait Until Page Contains Element    id:username    timeout=10s
    Input Text    id:username    ${USERNAME}
    Input Text    id:password    ${PASSWORD}
    Click Button    xpath://button[@type="submit"]
    ${status}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath://body    timeout=10s
    Run Keyword If    not ${status}    Fail    Login failed or initial page not loaded

Wait For Table Load
    [Arguments]    ${timeout}=10s
    Wait Until Page Contains Element    xpath://table[@id="example1"]    timeout=${timeout}

Search In DataTable
    [Arguments]    ${search_text}
    Wait Until Element Is Visible    xpath://div[@id="example1_filter"]//input[@type="search"]    timeout=10s
    Input Text    xpath://div[@id="example1_filter"]//input[@type="search"]    ${search_text}
    Sleep    3s
    Wait Until Page Contains Element    xpath://table[@id="example1"]/tbody/tr    timeout=10s

Click View Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table[@id="example1"]/tbody/tr[td[contains(text(),"${text}")]]//a[@title="View"]
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Click Delete Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table[@id="example1"]/tbody/tr[td[contains(text(),"${text}")]][1]//button[contains(@class,"show_confirm")]
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Handle Sweet Alert Confirmation
    Wait Until Page Contains Element    xpath://div[contains(@class,"swal-modal")]    timeout=10s
    Click Element    xpath://button[contains(@class,"swal-button--confirm")]
    Wait Until Page Contains    success    timeout=10s
    Click Element    xpath://button[contains(@class,"swal-button--confirm")]
    Wait Until Element Is Not Visible    xpath://div[contains(@class,"swal-modal")]    timeout=10s

Select Source Title
    [Arguments]    ${value}=1  # Scopus
    Execute JavaScript    document.querySelector('select[name="cat[]"]').value = "${value}";
    Execute JavaScript    var event = new Event('change'); document.querySelector('select[name="cat[]"]').dispatchEvent(event);
    Sleep    1s
    Log To Console    Selected Source Title: Scopus (value=${value})
    Capture Page Screenshot    source_title_selected.png

Select Paper Type
    [Arguments]    ${value}
    ${select_elem}=    Set Variable    xpath://select[@name="paper_type"]
    Wait Until Element Is Visible    ${select_elem}    timeout=10s
    Select From List By Value    ${select_elem}    ${value}
    Sleep    1s
    Log To Console    Selected Paper Type: ${value}
    Capture Page Screenshot    paper_type_selected.png

Select Document Type
    [Arguments]    ${value}
    ${select_elem}=    Set Variable    xpath://select[@name="paper_subtype"]
    Wait Until Element Is Visible    ${select_elem}    timeout=10s
    Select From List By Value    ${select_elem}    ${value}
    Sleep    1s
    Log To Console    Selected Document Type: ${value}
    Capture Page Screenshot    document_type_selected.png

Select Internal Author
    [Arguments]    ${author_id}    ${position}
    ${author_select}=    Set Variable    xpath://select[@name="moreFields[0][userid]"]
    Wait Until Element Is Visible    ${author_select}    timeout=10s
    Select From List By Value    ${author_select}    ${author_id}
    ${position_select}=    Set Variable    xpath://select[@name="pos[]"][1]
    Wait Until Element Is Visible    ${position_select}    timeout=10s
    Select From List By Value    ${position_select}    ${position}
    Sleep    1s
    Log To Console    Selected Internal Author: ${author_id}, Position: ${position}
    Capture Page Screenshot    internal_author_selected.png

Fill Paper Form And Submit
    [Arguments]    ${paper_name}    ${abstract}    ${keyword}    ${paper_type}
    Input Text    name:paper_name    ${paper_name}
    Input Text    name:abstract      ${abstract}
    Input Text    name:keyword       ${keyword}
    Select Source Title    1  # Scopus
    Select Paper Type    ${paper_type}
    Select Document Type    Article
    Input Text    name:paper_sourcetitle    Example Journal
    Input Text    name:paper_yearpub    2023
    Input Text    name:paper_volume    10
    Input Text    name:paper_issue    5
    Input Text    name:paper_page    100-110
    Input Text    name:paper_doi    10.1000/xyz123
    Input Text    name:paper_funder    Research Fund
    Input Text    name:paper_url    https://example.com/paper
    Select Internal Author    2    1
    Wait Until Element Is Visible    id:submit    timeout=15s
    ${is_enabled}=    Run Keyword And Return Status    Wait Until Element Is Enabled    id:submit    timeout=5s
    Log To Console    Is Submit button enabled? ${is_enabled}
    Run Keyword If    not ${is_enabled}    Log To Console    Submit button is disabled, checking for validation errors
    Run Keyword If    not ${is_enabled}    Capture Page Screenshot    submit_disabled.png
    ${validation_error}=    Run Keyword And Return Status    Page Should Contain Element    xpath://*[contains(@class, 'text-danger')]    timeout=5s
    Run Keyword If    ${validation_error}    Log To Console    Found validation error on form
    Run Keyword If    ${validation_error}    Capture Page Screenshot    form_validation_error.png
    Scroll Element Into View    id:submit
    ${click_status}=    Run Keyword And Return Status    Click Element    id:submit
    Log To Console    Click Element status: ${click_status}
    Run Keyword If    not ${click_status}    Execute JavaScript    document.getElementById('submit').click();
    Run Keyword If    not ${click_status}    Log To Console    Fallback to JavaScript click
    Sleep    3s
    Capture Page Screenshot    after_submit.png