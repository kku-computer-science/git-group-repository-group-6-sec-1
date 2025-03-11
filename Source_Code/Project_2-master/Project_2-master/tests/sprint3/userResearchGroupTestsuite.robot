*** Settings ***
Documentation    Test Suite for Research Groups Management System
Library          SeleniumLibrary
Suite Setup      Open Browser And Login
Suite Teardown   Close All Browsers

*** Variables ***
${LOGIN_URL}      http://127.0.0.1:8000/login
${RESEARCH_GROUPS_URL}    http://127.0.0.1:8000/researchGroups
${CREATE_URL}     http://127.0.0.1:8000/researchGroups/create

${BROWSER}        Firefox
${USERNAME}       pusadee@kku.ac.th
${PASSWORD}       123456789

${GROUP_NAME_TH}      test
${GROUP_NAME_EN}      test
${GROUP_DESC_TH}      test
${GROUP_DESC_EN}      test
${GROUP_DESC_ZH}      test
${GROUP_DETAIL_TH}    test
${GROUP_DETAIL_EN}    test
${GROUP_DETAIL_ZH}    test
${GROUP_HEAD}         watchara sritonwong
${GROUP_MEMBER}       watchara sritonwong

*** Test Cases ***
TC01 - Add New Research Group
    [Documentation]    Verify adding a new research group based on provided images
    Go To    ${CREATE_URL}
    Wait Until Page Contains    Create Research Group    timeout=30s
    Wait For Page Load
    # ตรวจสอบว่า jQuery และ Select2 โหลด
    Wait Until Page Contains Element    xpath://script[contains(@src, 'jquery')]    timeout=10s
    Wait Until Page Contains Element    xpath://script[contains(@src, 'select2')]    timeout=10s
    Execute JavaScript    return (typeof $ !== 'undefined' && $.fn.select2 !== undefined);
    Fill Research Group Form    ${GROUP_NAME_TH}    ${GROUP_NAME_EN}    ${GROUP_DESC_TH}    ${GROUP_DESC_EN}    ${GROUP_DESC_ZH}    ${GROUP_DETAIL_TH}    ${GROUP_DETAIL_EN}    ${GROUP_DETAIL_ZH}    ${GROUP_HEAD}    ${GROUP_MEMBER}
    # คลิกปุ่ม Submit
    Wait Until Element Is Visible    xpath://button[@type='submit']    timeout=10s
    ${is_enabled}=    Run Keyword And Return Status    Wait Until Element Is Enabled    xpath://button[@type='submit']    timeout=5s
    Run Keyword If    not ${is_enabled}    Fail    Submit button is disabled, possible validation error
    Run Keyword If    not ${is_enabled}    Capture Page Screenshot    submit_disabled.png
    ${validation_error}=    Run Keyword And Return Status    Page Should Contain Element    xpath://*[contains(@class, 'text-danger')]    timeout=5s
    Run Keyword If    ${validation_error}    Fail    Validation error found on form
    Run Keyword If    ${validation_error}    Capture Page Screenshot    validation_error.png
    Scroll Element Into View    xpath://button[@type='submit']
    Execute JavaScript    document.querySelector('button[type="submit"]').click();
    Wait Until Page Contains    success    timeout=15s
    ${current_url}=    Get Location
    Log To Console    Current URL after submit: ${current_url}
    Run Keyword If    '${current_url}' != '${RESEARCH_GROUPS_URL}'    Go To    ${RESEARCH_GROUPS_URL}
    Reload Page
    Wait For Table Load
    ${status}=    Run Keyword And Return Status    Wait Until Page Contains    research group created successfully    timeout=3s
    Run Keyword If    not ${status}    Log To Console    Warning: 'research group created successfully' not found, checking table for ${GROUP_NAME_TH}
    Search In DataTable    ${GROUP_NAME_TH}
    Wait Until Page Contains Element    xpath://table/tbody/tr[td[contains(text(), '${GROUP_NAME_TH}')]]    timeout=10s
    Page Should Contain    ${GROUP_NAME_TH}

TC02 - View Research Group Details
    [Documentation]    Verify viewing details of a newly created research group
    Go To    ${RESEARCH_GROUPS_URL}
    Wait For Table Load
    Search In DataTable    ${GROUP_NAME_TH}
    ${row}=    Get Element Count    xpath://table/tbody/tr[td[contains(text(), '${GROUP_NAME_TH}')]]
    Run Keyword If    ${row} > 0    Click View Button By Text    ${GROUP_NAME_TH}
    ...    ELSE    Fail    ${GROUP_NAME_TH} not found in table after search
    Wait For Page Load
    ${current_url}=    Get Location
    Log To Console    Current URL after view: ${current_url}
    Wait Until Page Contains Element    xpath://h4[contains(text(), 'Research Group')]    timeout=10s
    Page Should Contain    ${GROUP_NAME_TH}
    Page Should Contain    ${GROUP_NAME_EN}
    Page Should Contain    ${GROUP_DESC_TH}
    Page Should Contain    ${GROUP_DESC_EN}
    Page Should Contain    ${GROUP_DESC_ZH}
    Page Should Contain    ${GROUP_DETAIL_TH}
    Page Should Contain    ${GROUP_DETAIL_EN}
    Page Should Contain    ${GROUP_DETAIL_ZH}
    ${head_lowercase}=    Convert To Lowercase    ${GROUP_HEAD}
    Page Should Contain Element    xpath://p[contains(translate(text(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '${head_lowercase}')]
    ${member_lowercase}=    Convert To Lowercase    ${GROUP_MEMBER}
    Page Should Contain Element    xpath://p[contains(translate(text(), 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '${member_lowercase}')]
    Scroll Element Into View    xpath://a[contains(text(), 'Back')]
    Wait Until Element Is Visible    xpath://a[contains(text(), 'Back')]    timeout=2s
    Click Element    xpath://a[contains(text(), 'Back')]
    Wait For Table Load

*** Keywords ***
Clear Search Field
    Wait Until Element Is Visible    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    timeout=10s
    Input Text    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    ${EMPTY}
    Wait Until Page Contains Element    xpath://table/tbody/tr    timeout=10s

Open Browser And Login
    Open Browser    ${LOGIN_URL}    ${BROWSER}
    Maximize Browser Window
    Login To System
    ${current_url}=    Get Location
    Log To Console    URL after login: ${current_url}
    # บังคับไปยัง RESEARCH_GROUPS_URL เสมอ
    Go To    ${RESEARCH_GROUPS_URL}
    # รอหน้าโหลดและตรวจสอบตาราง
    ${status}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath://table    timeout=20s
    Run Keyword If    not ${status}    Log To Console    Warning: Table not found on ${RESEARCH_GROUPS_URL}, reloading...
    Run Keyword If    not ${status}    Reload Page
    Run Keyword If    not ${status}    Wait Until Page Contains Element    xpath://body    timeout=10s
    # รอ element อื่นที่บ่งบอกว่า RESEARCH_GROUPS_URL โหลดสำเร็จ
    Run Keyword If    not ${status}    Wait Until Page Contains    Research Groups    timeout=15s

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

Fill Research Group Form
    [Arguments]    ${name_th}    ${name_en}    ${desc_th}    ${desc_en}    ${desc_zh}    ${detail_th}    ${detail_en}    ${detail_zh}    ${head}    ${member}
    # กรอกข้อมูลในฟิลด์ข้อความ
    Wait Until Element Is Visible    name=group_name_th    timeout=10s
    Scroll Element Into View    name=group_name_th
    Execute JavaScript    document.querySelector('[name="group_name_th"]').value = "${name_th}";
    Execute JavaScript    var event = new Event('change'); document.querySelector('[name="group_name_th"]').dispatchEvent(event);
    Run Keyword And Ignore Error    Capture Page Screenshot    filename=debug_group_name_th_{index}.png

    Wait Until Element Is Visible    name=group_name_en    timeout=10s
    Scroll Element Into View    name=group_name_en
    Execute JavaScript    document.querySelector('[name="group_name_en"]').value = "${name_en}";
    Execute JavaScript    var event = new Event('change'); document.querySelector('[name="group_name_en"]').dispatchEvent(event);
    Run Keyword And Ignore Error    Capture Page Screenshot    filename=debug_group_name_en_{index}.png

    Wait Until Element Is Visible    name=group_desc_th    timeout=10s
    Scroll Element Into View    name=group_desc_th
    Execute JavaScript    document.querySelector('[name="group_desc_th"]').value = "${desc_th}";
    Execute JavaScript    var event = new Event('change'); document.querySelector('[name="group_desc_th"]').dispatchEvent(event);
    Run Keyword And Ignore Error    Capture Page Screenshot    filename=debug_group_desc_th_{index}.png

    Wait Until Element Is Visible    name=group_desc_en    timeout=10s
    Scroll Element Into View    name=group_desc_en
    Execute JavaScript    document.querySelector('[name="group_desc_en"]').value = "${desc_en}";
    Execute JavaScript    var event = new Event('change'); document.querySelector('[name="group_desc_en"]').dispatchEvent(event);
    Run Keyword And Ignore Error    Capture Page Screenshot    filename=debug_group_desc_en_{index}.png

    Wait Until Element Is Visible    name=group_desc_zh    timeout=10s
    Scroll Element Into View    name=group_desc_zh
    Execute JavaScript    document.querySelector('[name="group_desc_zh"]').value = "${desc_zh}";
    Execute JavaScript    var event = new Event('change'); document.querySelector('[name="group_desc_zh"]').dispatchEvent(event);
    Run Keyword And Ignore Error    Capture Page Screenshot    filename=debug_group_desc_zh_{index}.png

    Wait Until Element Is Visible    name=group_detail_th    timeout=10s
    Scroll Element Into View    name=group_detail_th
    Execute JavaScript    document.querySelector('[name="group_detail_th"]').value = "${detail_th}";
    Execute JavaScript    var event = new Event('change'); document.querySelector('[name="group_detail_th"]').dispatchEvent(event);
    Run Keyword And Ignore Error    Capture Page Screenshot    filename=debug_group_detail_th_{index}.png

    Wait Until Element Is Visible    name=group_detail_en    timeout=10s
    Scroll Element Into View    name=group_detail_en
    Execute JavaScript    document.querySelector('[name="group_detail_en"]').value = "${detail_en}";
    Execute JavaScript    var event = new Event('change'); document.querySelector('[name="group_detail_en"]').dispatchEvent(event);
    Run Keyword And Ignore Error    Capture Page Screenshot    filename=debug_group_detail_en_{index}.png

    Wait Until Element Is Visible    name=group_detail_zh    timeout=10s
    Scroll Element Into View    name=group_detail_zh
    Execute JavaScript    document.querySelector('[name="group_detail_zh"]').value = "${detail_zh}";
    Execute JavaScript    var event = new Event('change'); document.querySelector('[name="group_detail_zh"]').dispatchEvent(event);
    Run Keyword And Ignore Error    Capture Page Screenshot    filename=debug_group_detail_zh_{index}.png

    # เลือก Group Head จาก Select2 ด้วย JavaScript
    Wait Until Element Is Visible    id=head0    timeout=10s
    Wait Until Page Contains Element    css=.select2-container    timeout=15s
    Scroll Element Into View    id=head0
    # ใช้ JavaScript เพื่อเลือกค่าใน Select2 (ต้องแทน "some_value" ด้วยค่า value จริงของ watchara sritonwong)
    ${head_value}=    Set Variable    some_value  # แทนด้วย value จริงจาก <option> ของ watchara sritonwong
    Execute JavaScript    $("#head0").val("${head_value}").trigger("change");
    Wait Until Element Is Visible    css=span[id='select2-head0-container']    timeout=2s
    Run Keyword And Ignore Error    Capture Page Screenshot    filename=debug_group_head_selected_{index}.png

    # เพิ่มและเลือก Group Member (Internal)
    Wait Until Element Is Visible    id=add-btn2    timeout=10s
    Wait Until Element Is Enabled    id=add-btn2    timeout=10s
    Scroll Element Into View    id=add-btn2
    Execute JavaScript    document.getElementById('add-btn2').click();
    Wait Until Element Is Visible    id=selUser0    timeout=10s
    Scroll Element Into View    id=selUser0
    # ใช้ JavaScript เพื่อเลือกค่าใน Select2 (ต้องแทน "some_value" ด้วยค่า value จริงของ watchara sritonwong)
    ${member_value}=    Set Variable    some_value  # แทนด้วย value จริงจาก <option> ของ watchara sritonwong
    Execute JavaScript    $("#selUser0").val("${member_value}").trigger("change");
    Wait Until Element Is Visible    css=span[id='select2-selUser0-container']    timeout=2s
    Run Keyword And Ignore Error    Capture Page Screenshot    filename=debug_group_member_selected_{index}.png

    # ตรวจสอบข้อมูล
    ${group_name_th_value}=    Get Element Attribute    name=group_name_th    value
    Should Be Equal    ${group_name_th_value}    ${name_th}    msg=Failed to input Group Name (Thai)

Search In DataTable
    [Arguments]    ${search_text}
    Wait Until Element Is Visible    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    timeout=10s
    Input Text    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    ${search_text}
    Wait Until Page Contains Element    xpath://table/tbody/tr    timeout=20s

Click View Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table/tbody/tr[td[contains(text(), '${text}')]]//a[contains(@class, 'btn-outline-primary') and contains(@title, 'View')]
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Wait Until Element Is Enabled    ${locator}    timeout=10s
    Click Element    ${locator}