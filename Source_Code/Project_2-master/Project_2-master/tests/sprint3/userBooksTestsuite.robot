*** Settings ***
Documentation    Test Suite for Research Books Management System
Library          SeleniumLibrary
Suite Setup      Open Browser And Login
Suite Teardown   Close All Browsers

*** Variables ***
${LOGIN_URL}      https://cs6sec267.cpkkuhost.com/login
${BOOKS_URL}      https://cs6sec267.cpkkuhost.com/books
${CREATE_URL}     https://cs6sec267.cpkkuhost.com/books/create
${VIEW_URL}       https://cs6sec267.cpkkuhost.com/books/20
${EDIT_URL}       https://cs6sec267.cpkkuhost.com/books/20/edit

${BROWSER}        chrome
${USERNAME}       punhor1@kku.ac.th
${PASSWORD}       123456789

# ปรับข้อมูลให้เป็นทางการและวันที่ให้เหมาะสม
${BOOK_NAME}      การวิเคราะห์ข้อมูลเกษตรด้วยปัญญาประดิษฐ์
${PUBLICATION}    สำนักพิมพ์มหาวิทยาลัยขอนแก่น
${YEAR}           2025-03-09  # รูปแบบ YYYY-MM-DD สำหรับ JavaScript
${PAGE}           150

${UPDATED_BOOK_NAME}  การวิเคราะห์ข้อมูลเกษตรด้วย AI รุ่นปรับปรุง
${UPDATED_PUBLICATION}  สำนักพิมพ์เทคโนโลยีเกษตร
${UPDATED_YEAR}   2025-06-15  # รูปแบบ YYYY-MM-DD สำหรับ JavaScript
${UPDATED_PAGE}   180

*** Test Cases ***
TC01 - Add New Book
    [Documentation]    Verify adding a new book
    Go To    ${CREATE_URL}
    Wait For Page Load
    Fill Book Form    ${BOOK_NAME}    ${PUBLICATION}    ${YEAR}    ${PAGE}
    Scroll Element Into View    xpath://button[@type='submit']
    Click Element    xpath://button[@type='submit']
    Sleep    2s
    ${current_url}=    Get Location
    Log To Console    Current URL after submit: ${current_url}
    Run Keyword If    '${current_url}' != '${BOOKS_URL}'    Go To    ${BOOKS_URL}
    Reload Page
    Wait For Table Load
    ${status}=    Run Keyword And Return Status    Wait Until Page Contains    book created successfully    timeout=3s
    Run Keyword If    not ${status}    Log To Console    Warning: 'book created successfully' not found, checking table for ${BOOK_NAME}
    Search In DataTable    ${BOOK_NAME}
    Wait Until Page Contains Element    xpath://table/tbody/tr[td[contains(text(), '${BOOK_NAME}')]]    timeout=10s
    Page Should Contain    ${BOOK_NAME}

TC02 - View Book Details
    [Documentation]    Verify viewing details of a newly created book
    Go To    ${BOOKS_URL}
    Wait For Table Load
    Search In DataTable    ${BOOK_NAME}
    ${row}=    Get Element Count    xpath://table/tbody/tr[td[contains(text(), '${BOOK_NAME}')]]
    Run Keyword If    ${row} > 0    Click View Button By Text    ${BOOK_NAME}
    ...    ELSE    Fail    ${BOOK_NAME} not found in table after search
    Sleep    2s
    Wait For Page Load
    ${current_url}=    Get Location
    Log To Console    Current URL after view: ${current_url}
    Page Should Contain Element    xpath://h4[contains(text(), 'Book Detail')]
    Page Should Contain    ${BOOK_NAME}
    Page Should Contain    ${PUBLICATION}
    Page Should Contain    ${PAGE}
    ${year_to_check}=    Set Variable    2025  # ใช้เฉพาะปีในการตรวจสอบ
    Page Should Contain    ${year_to_check}
    Click Element    xpath://a[contains(text(), 'Back')]
    Wait For Table Load

TC03 - Edit Book
    [Documentation]    Verify editing an existing book
    Go To    ${BOOKS_URL}
    Wait For Table Load
    Search In DataTable    ${BOOK_NAME}
    ${row}=    Get Element Count    xpath://table/tbody/tr[td[contains(text(), '${BOOK_NAME}')]]
    Run Keyword If    ${row} > 0    Click Edit Button By Text    ${BOOK_NAME}
    ...    ELSE    Fail    ${BOOK_NAME} not found in table after search
    Wait For Page Load
    Fill Book Form    ${UPDATED_BOOK_NAME}    ${UPDATED_PUBLICATION}    ${UPDATED_YEAR}    ${UPDATED_PAGE}
    Scroll Element Into View    xpath://button[@type='submit']
    Click Element    xpath://button[@type='submit']
    Wait Until Page Contains    Book updated successfully    timeout=10s
    Go To    ${BOOKS_URL}
    Wait For Table Load
    Search In DataTable    ${UPDATED_BOOK_NAME}
    Wait Until Page Contains Element    xpath://table/tbody/tr[td[contains(text(), '${UPDATED_BOOK_NAME}')]]    timeout=10s
    Page Should Contain    ${UPDATED_BOOK_NAME}

TC04 - Delete Updated Book
    [Documentation]    Verify deleting the updated book without Sweet Alert
    [Tags]    critical    deletion
    Go To    ${BOOKS_URL}
    Wait For Table Load
    Search In DataTable    ${UPDATED_BOOK_NAME}
    ${row}=    Get Element Count    xpath://table/tbody/tr[td[contains(text(), '${UPDATED_BOOK_NAME}')]]
    Run Keyword If    ${row} > 0    Click Delete Button By Text    ${UPDATED_BOOK_NAME}
    ...    ELSE    Fail    ${UPDATED_BOOK_NAME} not found in table after search
    Wait For Table Load
    Search In DataTable    ${UPDATED_BOOK_NAME}
    ${row_after_delete}=    Get Element Count    xpath://table/tbody/tr[td[contains(text(), '${UPDATED_BOOK_NAME}')]]
    Should Be Equal As Numbers    ${row_after_delete}    0    msg=${UPDATED_BOOK_NAME} still exists after deletion
    Log To Console    Deletion of ${UPDATED_BOOK_NAME} verified successfully

*** Keywords ***
Clear Search Field
    Wait Until Element Is Visible    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    timeout=10s
    Input Text    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    ${EMPTY}
    Sleep    2s
    Wait Until Page Contains Element    xpath://table/tbody/tr    timeout=10s

Open Browser And Login
    Open Browser    ${LOGIN_URL}    ${BROWSER}
    Maximize Browser Window
    Login To System
    ${current_url}=    Get Location
    Run Keyword If    '${current_url}' != '${BOOKS_URL}'    Go To    ${BOOKS_URL}
    Wait Until Page Contains Element    xpath://table    timeout=10s

Login To System
    Wait Until Page Contains Element    id=username    timeout=10s
    Log To Console    Found username field
    Input Text    id=username    ${USERNAME}
    Input Text    id=password    ${PASSWORD}
    Click Button    xpath://button[@type='submit']
    ${status}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath://body    timeout=10s
    Run Keyword If    not ${status}    Fail    Login failed or initial page not loaded
    Log To Console    Login successful

Wait For Page Load
    [Arguments]    ${timeout}=10s
    Wait Until Page Contains Element    xpath://body    timeout=${timeout}

Wait For Table Load
    [Arguments]    ${timeout}=20s
    Wait Until Page Contains Element    xpath://table    timeout=${timeout}
    Log To Console    Table loaded successfully

Search In DataTable
    [Arguments]    ${search_text}
    Wait Until Element Is Visible    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    timeout=10s
    Input Text    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    ${search_text}
    Sleep    3s
    Wait Until Page Contains Element    xpath://table/tbody/tr    timeout=20s

Click View Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table/tbody/tr[td[contains(text(), '${text}')]]//a[contains(@class, 'btn-outline-primary') and contains(@title, 'View')]
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Click Edit Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table/tbody/tr[td[contains(text(), '${text}')]]//a[contains(@class, 'btn-outline-success') and contains(@title, 'Edit')]
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Click Delete Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table/tbody/tr[td[contains(text(), '${text}')]]//button[contains(@class, 'btn-outline-danger') or contains(@title, 'Delete')]
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Fill Book Form
    [Arguments]    ${name}    ${publication}    ${year}    ${page}
    ${name}=    Evaluate    '${name}'.strip()
    Wait Until Element Is Visible    name=ac_name    timeout=10s
    Input Text    name=ac_name    ${name}
    Wait Until Element Is Visible    name=ac_sourcetitle    timeout=10s
    Input Text    name=ac_sourcetitle    ${publication}
    # ใช้ JavaScript กรอกวันที่เหมือนโค้ดก่อนหน้า
    Wait Until Element Is Visible    name=ac_year    timeout=10s
    Execute JavaScript    document.querySelector('[name="ac_year"]').value = "${year}";
    Wait Until Element Is Visible    name=ac_page    timeout=10s
    Input Text    name=ac_page    ${page}
    # ตรวจสอบการกรอก
    ${book_name_value}=    Get Element Attribute    name=ac_name    value
    Should Be Equal    ${book_name_value}    ${name}    msg=Failed to input Book Name
    ${year_value}=    Execute JavaScript    return document.querySelector('[name="ac_year"]').value;
    Should Be Equal    ${year_value}    ${year}    msg=Failed to input Year