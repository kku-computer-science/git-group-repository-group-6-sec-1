*** Settings ***
Documentation    Test Suite for Research Groups Management System
Library          SeleniumLibrary
Library          String
Suite Setup      Open Browser And Login
Suite Teardown   Close All Browsers

*** Variables ***
${LOGIN_URL}      http://127.0.0.1:8000/login
${RESEARCH_GROUPS_URL}    http://127.0.0.1:8000/researchGroups
${CREATE_URL}     http://127.0.0.1:8000/researchGroups/create

${BROWSER}        chrome
${USERNAME}       pusadee@kku.ac.th
${PASSWORD}       123456789

# ปรับข้อมูลให้เป็นทางการ
${GROUP_NAME_TH}      กลุ่มวิจัยปัญญาประดิษฐ์เพื่อการเกษตร
${GROUP_NAME_EN}      Artificial Intelligence for Agriculture Research Group
${GROUP_DESC_TH}      กลุ่มวิจัยที่มุ่งพัฒนาเทคโนโลยี AI เพื่อเพิ่มประสิทธิภาพการเกษตร
${GROUP_DESC_EN}      A research group focused on developing AI technology to enhance agricultural efficiency
${GROUP_DESC_ZH}      人工智能农业研究小组，致力于提升农业效率
${GROUP_DETAIL_TH}    กลุ่มนี้มุ่งเน้นการประยุกต์ใช้ปัญญาประดิษฐ์ในการวิเคราะห์ข้อมูลเกษตร เช่น การพยากรณ์ผลผลิต และการจัดการทรัพยากรอย่างยั่งยืน
${GROUP_DETAIL_EN}    This group focuses on applying artificial intelligence to analyze agricultural data, such as yield prediction and sustainable resource management
${GROUP_DETAIL_ZH}    该小组专注于将人工智能应用于农业数据分析，例如产量预测和可持续资源管理
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
    ${jquery_loaded}=    Execute JavaScript    return (typeof $ !== 'undefined' && $.fn.select2 !== undefined);
    Run Keyword If    not ${jquery_loaded}    Fail    jQuery or Select2 not loaded properly
    Fill Research Group Form    ${GROUP_NAME_TH}    ${GROUP_NAME_EN}    ${GROUP_DESC_TH}    ${GROUP_DESC_EN}    ${GROUP_DESC_ZH}    ${GROUP_DETAIL_TH}    ${GROUP_DETAIL_EN}    ${GROUP_DETAIL_ZH}    ${GROUP_HEAD}    ${GROUP_MEMBER}
    # คลิกปุ่ม Submit
    Wait Until Element Is Visible    xpath://button[@type='submit']    timeout=10s
    ${is_enabled}=    Run Keyword And Return Status    Wait Until Element Is Enabled    xpath://button[@type='submit']    timeout=5s
    Run Keyword If    not ${is_enabled}    Fail    Submit button is disabled, possible validation error
    Run Keyword If    not ${is_enabled}    Capture Page Screenshot    submit_disabled.png
    ${validation_error}=    Run Keyword And Return Status    Page Should Contain Element    xpath://*[contains(@class, 'text-danger')]    timeout=5s
    Run Keyword If    ${validation_error}    Fail    Validation error found on form
    Run Keyword If    ${validation_error}    Capture Page Screenshot    validation_error.png
    Execute JavaScript    document.querySelector('button[type="submit"]').scrollIntoView(true); document.querySelector('button[type="submit"]').click();
    Wait Until Page Contains    success    timeout=15s
    Go To    ${RESEARCH_GROUPS_URL}
    Reload Page
    Wait For Table Load
    Search In DataTable    ${GROUP_NAME_TH}
    ${row}=    Get Element Count    xpath://table/tbody/tr[td[contains(text(), '${GROUP_NAME_TH}')]]
    Run Keyword If    ${row} > 0    Log    Found research group "${GROUP_NAME_TH}" in table
    ...    ELSE    Fail    Research group "${GROUP_NAME_TH}" not found in table after creation
    Page Should Contain    ${GROUP_NAME_TH}
    Capture Page Screenshot    after_add_research_group.png

TC02 - View Research Group Details
    [Documentation]    Verify viewing details of a newly created research group by searching and clicking View
    Go To    ${RESEARCH_GROUPS_URL}
    Wait For Table Load
    Clear Search Field
    Search In DataTable    ${GROUP_NAME_TH}
    ${row}=    Get Element Count    xpath://table/tbody/tr[td[contains(text(), '${GROUP_NAME_TH}')]]
    Run Keyword If    ${row} > 0    Click View Button By Text    ${GROUP_NAME_TH}
    ...    ELSE    Fail    ${GROUP_NAME_TH} not found in table after search
    Wait For Page Load
    ${current_url}=    Get Location
    Log To Console    Current URL after view: ${current_url}
    # ตรวจสอบว่าเข้าสู่หน้ารายละเอียดได้สำเร็จ
    Wait Until Page Contains Element    xpath://h4[contains(text(), 'Research Group')]    timeout=10s
    Page Should Contain    ${GROUP_NAME_TH}    # ตรวจสอบแค่ชื่อกลุ่มภาษาไทยก็พอ

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
    Go To    ${RESEARCH_GROUPS_URL}
    ${status}=    Run Keyword And Return Status    Wait Until Page Contains Element    xpath://table    timeout=20s
    Run Keyword If    not ${status}    Log To Console    Warning: Table not found on ${RESEARCH_GROUPS_URL}, reloading...
    Run Keyword If    not ${status}    Reload Page
    Run Keyword If    not ${status}    Wait Until Page Contains Element    xpath://body    timeout=10s
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
    # กรอกข้อมูลในฟิลด์ข้อความด้วย JavaScript
    Wait Until Element Is Visible    name=group_name_th    timeout=10s
    Execute JavaScript    document.querySelector('[name="group_name_th"]').scrollIntoView(true); document.querySelector('[name="group_name_th"]').value = "${name_th}";

    Wait Until Element Is Visible    name=group_name_en    timeout=10s
    Execute JavaScript    document.querySelector('[name="group_name_en"]').scrollIntoView(true); document.querySelector('[name="group_name_en"]').value = "${name_en}";

    Wait Until Element Is Visible    name=group_desc_th    timeout=10s
    Execute JavaScript    document.querySelector('[name="group_desc_th"]').scrollIntoView(true); document.querySelector('[name="group_desc_th"]').value = "${desc_th}";

    Wait Until Element Is Visible    name=group_desc_en    timeout=10s
    Execute JavaScript    document.querySelector('[name="group_desc_en"]').scrollIntoView(true); document.querySelector('[name="group_desc_en"]').value = "${desc_en}";

    Wait Until Element Is Visible    name=group_desc_zh    timeout=10s
    Execute JavaScript    document.querySelector('[name="group_desc_zh"]').scrollIntoView(true); document.querySelector('[name="group_desc_zh"]').value = "${desc_zh}";

    Wait Until Element Is Visible    name=group_detail_th    timeout=10s
    Execute JavaScript    document.querySelector('[name="group_detail_th"]').scrollIntoView(true); document.querySelector('[name="group_detail_th"]').value = "${detail_th}";

    Wait Until Element Is Visible    name=group_detail_en    timeout=10s
    Execute JavaScript    document.querySelector('[name="group_detail_en"]').scrollIntoView(true); document.querySelector('[name="group_detail_en"]').value = "${detail_en}";

    Wait Until Element Is Visible    name=group_detail_zh    timeout=10s
    Execute JavaScript    document.querySelector('[name="group_detail_zh"]').scrollIntoView(true); document.querySelector('[name="group_detail_zh"]').value = "${detail_zh}";

    # เลือก Group Head จาก Select2 (สมมติ value ของ watchara sritonwong = 44 จาก HTML ก่อนหน้า)
    Wait Until Element Is Visible    id=head0    timeout=10s
    Execute JavaScript    document.querySelector('#head0').scrollIntoView(true); $("#head0").val("44").trigger("change");
    Wait Until Element Is Visible    css=span[id='select2-head0-container']    timeout=5s

    # เพิ่มและเลือก Group Member (Internal)
    Wait Until Element Is Visible    id=add-btn2    timeout=10s
    Execute JavaScript    document.getElementById('add-btn2').scrollIntoView(true); document.getElementById('add-btn2').click();
    Wait Until Element Is Visible    id=selUser0    timeout=10s
    Execute JavaScript    document.querySelector('#selUser0').scrollIntoView(true); $("#selUser0").val("44").trigger("change");
    Wait Until Element Is Visible    css=span[id='select2-selUser0-container']    timeout=5s

    # ตรวจสอบข้อมูลที่กรอก
    ${group_name_th_value}=    Execute JavaScript    return document.querySelector('[name="group_name_th"]').value;
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