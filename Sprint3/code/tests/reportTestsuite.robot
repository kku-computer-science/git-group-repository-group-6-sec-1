*** Settings ***
Library         SeleniumLibrary
Test Setup      Open Browser To Report Page
Test Teardown   Close Browser

*** Variables ***
${URL}              http://127.0.0.1:8000
${BROWSER}          Chrome
${REPORT_URL}       http://127.0.0.1:8000/reports

*** Test Cases ***
TC26_Report_Translation
    [Documentation]    ตรวจสอบภาษาที่ Report
    Go To    ${REPORT_URL}
    Check Report Translations

*** Keywords ***
Open Browser To Report Page
    Open Browser    ${REPORT_URL}    ${BROWSER}
    Maximize Browser Window
    Log To Console    Opened browser to: ${REPORT_URL}

Switch Language
    [Arguments]    ${lang}
    ${current_url}=    Get Location
    Log To Console    Current URL before switching: ${current_url}
    Go To    ${URL}/lang/${lang}
    Wait Until Page Contains Element    xpath://body    timeout=15s  # รอ <body> เพื่อยืนยันหน้าโหลด
    ${new_url}=    Get Location
    Log To Console    Switched to language: ${lang}, new URL: ${new_url}

Check Text Case Insensitive
    [Arguments]    ${locator}    ${expected_text}
    ${actual_text}=    Get Text    ${locator}
    Log To Console    Actual text found at ${locator}: ${actual_text}
    Should Be Equal As Strings    ${actual_text}    ${expected_text}    ignore_case=True

Check Report Translations
    Set Selenium Timeout    15s
    # Thai
    Switch Language    th
    Wait Until Element Is Visible    xpath://h4[contains(@class, 'card-title')]    timeout=15s
    Check Text Case Insensitive    xpath://h4[contains(@class, 'card-title')][1]    สถิติจำนวนบทความทั้งหมด 5 ปี
    Check Text Case Insensitive    xpath://h5[contains(@class, 'card-title')]   สถิติจำนวนบทความที่ได้รับการอ้างอิง
    # English
    Switch Language    en
    Wait Until Element Is Visible    xpath://h4[contains(@class, 'card-title')]    timeout=15s
    Check Text Case Insensitive    xpath://h4[contains(@class, 'card-title')][1]    Statistics of Total Articles Over 5 Years
    Check Text Case Insensitive    xpath://h5[contains(@class, 'card-title')]    Statistics of Cited Articles
    # Chinese
    Switch Language    zh
    Wait Until Element Is Visible    xpath://h4[contains(@class, 'card-title')]    timeout=15s
    Check Text Case Insensitive    xpath://h4[contains(@class, 'card-title')][1]    五年文章总数统计
    Check Text Case Insensitive    xpath://h5[contains(@class, 'card-title')]    被引文章统计