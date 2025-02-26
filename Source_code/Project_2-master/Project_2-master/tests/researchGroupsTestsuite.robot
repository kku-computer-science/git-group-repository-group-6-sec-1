*** Settings ***
Library         SeleniumLibrary
Test Setup      Open Browser To ResearchGroup Page
Test Teardown   Close Browser

*** Variables ***
${URL}              http://127.0.0.1:8000
${BROWSER}          Chrome
${RESEARCH_GROUP_URL}    http://127.0.0.1:8000/researchgroup
${RESEARCH_GROUP_DETAIL_URL}    http://127.0.0.1:8000/researchgroupdetail

*** Test Cases ***
TC24_ResearcherGroup_TableTranslation
    [Documentation]    ตรวจสอบภาษาข้อมูลส่วนต่างๆ ในแต่ละ card ที่ Research Group
    Go To    ${RESEARCH_GROUP_URL}
    Check Research Group Translations

TC25_ResearcherGroup_DetailTableTranslation
    [Documentation]    ตรวจสอบภาษาในหน้า Detail ของทุกกลุ่มวิจัย
    @{ids}=    Create List    3    5    10    8    9
    Log To Console    Group IDs before loop: @{ids}
    FOR    ${id}    IN    @{ids}
        Go To    ${RESEARCH_GROUP_DETAIL_URL}/${id}
        Check Research Group Detail Translations
    END

*** Keywords ***
Open Browser To ResearchGroup Page
    Open Browser    ${RESEARCH_GROUP_URL}    ${BROWSER}
    Maximize Browser Window
    Log To Console    Opened browser to: ${RESEARCH_GROUP_URL}

Switch Language
    [Arguments]    ${lang}
    ${current_url}=    Get Location
    Log To Console    Current URL before switching: ${current_url}
    Go To    ${URL}/lang/${lang}
    Wait Until Page Contains Element    xpath://body    timeout=15s
    ${new_url}=    Get Location
    Log To Console    Switched to language: ${lang}, new URL: ${new_url}

Check Text Case Insensitive
    [Arguments]    ${locator}    ${expected_text}
    ${actual_text}=    Get Text    ${locator}
    Log To Console    Actual text found at ${locator}: ${actual_text}
    Should Be Equal As Strings    ${actual_text}    ${expected_text}    ignore_case=True

Check Research Group Translations
    Set Selenium Timeout    15s
    # Thai
    Switch Language    th
    Wait Until Element Is Visible    xpath://p    timeout=15s
    Check Text Case Insensitive    xpath://p    กลุ่มวิจัย
    Check Text Case Insensitive    xpath://div[contains(@class, 'card')]//h2[contains(@class, 'card-text-1')]    หัวหน้าห้องปฏิบัติการ
    Check Text Case Insensitive    xpath://div[contains(@class, 'card')]//a[contains(@class, 'btn')]    รายละเอียด
    # English
    Switch Language    en
    Wait Until Element Is Visible    xpath://p    timeout=15s
    Check Text Case Insensitive    xpath://p    Research Group
    Check Text Case Insensitive    xpath://div[contains(@class, 'card')]//h2[contains(@class, 'card-text-1')]    laboratory supervisor
    Check Text Case Insensitive    xpath://div[contains(@class, 'card')]//a[contains(@class, 'btn')]    Details
    # Chinese
    Switch Language    zh
    Wait Until Element Is Visible    xpath://p    timeout=15s
    Check Text Case Insensitive    xpath://p    研究小组
    Check Text Case Insensitive    xpath://div[contains(@class, 'card')]//h2[contains(@class, 'card-text-1')]    实验室负责人
    Check Text Case Insensitive    xpath://div[contains(@class, 'card')]//a[contains(@class, 'btn')]    详情

Check Research Group Detail Translations
    Set Selenium Timeout    15s
    # Thai
    Switch Language    th
    Wait Until Element Is Visible    xpath://p    timeout=15s
    Check Text Case Insensitive    xpath://p    กลุ่มวิจัย
    Check Text Case Insensitive    xpath://h1[contains(@class, 'card-text-1')][1]    หัวหน้าห้องปฏิบัติการ
    Check Text Case Insensitive    xpath://h1[contains(@class, 'card-text-1')][2]    นักศึกษา
    # English
    Switch Language    en
    Wait Until Element Is Visible    xpath://p    timeout=15s
    Check Text Case Insensitive    xpath://p    Research Group
    Check Text Case Insensitive    xpath://h1[contains(@class, 'card-text-1')][1]    laboratory supervisor
    Check Text Case Insensitive    xpath://h1[contains(@class, 'card-text-1')][2]    Student
    # Chinese
    Switch Language    zh
    Wait Until Element Is Visible    xpath://p    timeout=15s
    Check Text Case Insensitive    xpath://p    研究小组
    Check Text Case Insensitive    xpath://h1[contains(@class, 'card-text-1')][1]    实验室负责人
    Check Text Case Insensitive    xpath://h1[contains(@class, 'card-text-1')][2]    学生