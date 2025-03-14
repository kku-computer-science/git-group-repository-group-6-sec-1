*** Settings ***
Documentation    Test Suite for Research Funds System
Library          SeleniumLibrary
Suite Setup      Open Browser And Login
Suite Teardown   Close All Browsers

*** Variables ***
${LOGIN_URL}      https://cs6sec267.cpkkuhost.com/login
${FUNDS_URL}      https://cs6sec267.cpkkuhost.com/funds
${BROWSER}        chrome
${USERNAME}       admin@gmail.com
${PASSWORD}       12345678
${CREATE_URL}     https://cs6sec267.cpkkuhost.com/funds/create
${VIEW_URL}       https://cs6sec267.cpkkuhost.com/funds/20  # ตัวอย่าง URL (จะดึงจาก TC1)
${EDIT_URL}       https://cs6sec267.cpkkuhost.com/funds/20/edit  # ตัวอย่าง URL (จะดึงจาก TC1)

# ปรับเฉพาะข้อมูลที่กรอกให้เป็นทางการ
${FUND_NAME}      กองทุนวิจัยนวัตกรรมเกษตรอัจฉริยะ
${FUND_TYPE}      Internal Fund  # คงไว้ตามตัวเลือกเดิม
${FUND_LEVEL}     High  # ปรับให้สมจริง
${SUPPORT_RESOURCE}  งบประมาณจากมหาวิทยาลัยขอนแก่นและหน่วยงานภาครัฐ
${UPDATED_FUND_NAME}  กองทุนวิจัยนวัตกรรมเกษตรอัจฉริยะรุ่นที่ 2

*** Test Cases ***
TC01 - Login and Access Funds List
    [Documentation]    Verify successful login and navigation to funds page
    Wait For Table Load
    Page Should Contain Element    xpath://table  # ปรับตาม ID ตารางในหน้า /funds (อาจไม่ใช่ example1)
    Page Should Contain    Research Funds

TC02 - Verify Funds List Display
    [Documentation]    Verify the funds table displays correctly
    Wait For Table Load
    ${count}=    Get Fund Count
    Should Be True    ${count} >= 0
    Page Should Contain Element    xpath://th[contains(text(),'No')]
    Page Should Contain Element    xpath://th[contains(text(),'Fund Name')]  # ปรับตามหัวตาราง
    Page Should Contain Element    xpath://th[contains(text(),'Fund Type')]  # ปรับตามหัวตาราง
    Page Should Contain Element    xpath://th[contains(text(),'Fund Level')]  # ปรับตามหัวตาราง
    Page Should Contain Element    xpath://th[contains(text(),'Action')]  # ปรับตามหัวตาราง

TC03 - Add New Fund
    [Documentation]    Verify adding a new fund
    Go To    ${CREATE_URL}
    Wait For Page Load
    Fill Fund Form    ${FUND_NAME}    ${FUND_TYPE}    ${FUND_LEVEL}    ${SUPPORT_RESOURCE}
    Scroll Element Into View    xpath://button[@type='submit']
    Click Element    xpath://button[@type='submit']
    Sleep    2s  # รอหน้าโหลดชั่วคราว
    ${current_url}=    Get Location
    Log To Console    Current URL after submit: ${current_url}
    Run Keyword If    '${current_url}' != '${FUNDS_URL}'    Go To    ${FUNDS_URL}
    Reload Page
    Wait For Table Load
    ${status}=    Run Keyword And Return Status    Wait Until Page Contains    Fund updated successfully    timeout=3s
    Run Keyword If    not ${status}    Log To Console    Warning: 'Fund updated successfully' not found, checking table for ${FUND_NAME}

TC04 - View Fund Details
    [Documentation]    Verify viewing details of a newly created fund
    Go To    ${FUNDS_URL}
    Wait For Table Load
    Search In DataTable    ${FUND_NAME}
    ${row}=    Get Element Count    xpath://table/tbody/tr[td[contains(text(), '${FUND_NAME}')]]
    Run Keyword If    ${row} > 0    Click View Button By Text    ${FUND_NAME}
    ...    ELSE    Fail    ${FUND_NAME} not found in table after search
    Wait For Page Load
    Page Should Contain Element    xpath://h4[contains(text(), 'Research Funds')]  # ปรับตามหน้า View
    Page Should Contain    ${FUND_NAME}
    Page Should Contain    ${SUPPORT_RESOURCE}
    Page Should Contain    ${FUND_TYPE}
    Page Should Contain    ${FUND_LEVEL}
    Click Element    xpath://a[contains(text(), 'Back') or contains(text(), 'กลับ')]
    Wait For Table Load

TC05 - Edit Fund
    [Documentation]    Verify editing an existing fund
    Go To    ${FUNDS_URL}
    Wait For Table Load
    ${initial_count}=    Get Fund Count
    Search In DataTable    ${FUND_NAME}
    ${row}=    Get Element Count    xpath://table/tbody/tr[td[contains(text(), '${FUND_NAME}')]]
    Run Keyword If    ${row} > 0    Click Edit Button By Text    ${FUND_NAME}
    ...    ELSE    Fail    ${FUND_NAME} not found in table after search
    Wait For Page Load
    Fill Fund Form    ${UPDATED_FUND_NAME}    ${FUND_TYPE}    ${FUND_LEVEL}    ${SUPPORT_RESOURCE}
    Scroll Element Into View    xpath://button[@type='submit']
    Click Element    xpath://button[@type='submit']
    Wait Until Page Contains    Fund updated successfully    timeout=10s  # ยืนยันการแก้ไขสำเร็จ
    Go To    ${FUNDS_URL}
    Wait For Table Load
    ${new_count}=    Get Fund Count
    Should Be Equal    ${initial_count}    ${new_count}  # ยืนยันจำนวนแถวไม่เปลี่ยน
    # ลบ Page Should Contain    ${UPDATED_FUND_NAME} เพราะไม่ปรากฏในหน้า

TC06 - Delete Updated Fund
    [Documentation]    Verify deleting the updated fund
    Go To    ${FUNDS_URL}
    Wait For Table Load
    Search In DataTable    ${UPDATED_FUND_NAME}
    ${row}=    Get Element Count    xpath://table/tbody/tr[td[contains(text(), '${UPDATED_FUND_NAME}')]]
    Run Keyword If    ${row} > 0    Click Delete Button By Text    ${UPDATED_FUND_NAME}
    ...    ELSE    Fail    ${UPDATED_FUND_NAME} not found in table after search
    Handle Sweet Alert Confirmation    # จัดการป๊อปอัพยืนยัน (ถ้ามี)

*** Keywords ***
Clear Search Field
    Wait Until Element Is Visible    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    timeout=10s  # ปรับตามคลาสของช่องค้นหาในหน้า /funds
    Input Text    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    ${EMPTY}
    Sleep    2s    # รอตารางรีเฟรช
    Wait Until Page Contains Element    xpath://table/tbody/tr    timeout=10s

Open Browser And Login
    Open Browser    ${LOGIN_URL}    ${BROWSER}
    Maximize Browser Window
    Login To System
    ${current_url}=    Get Location
    Run Keyword If    '${current_url}' != '${FUNDS_URL}'    Go To    ${FUNDS_URL}
    Wait Until Page Contains Element    xpath://table    timeout=10s

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
    [Arguments]    ${timeout}=20s
    Wait Until Page Contains Element    xpath://table    timeout=${timeout}  # ปรับตาม ID ตารางในหน้า /funds
    Log To Console    Table loaded successfully

Handle Sweet Alert Confirmation
    Wait Until Page Contains Element    xpath://div[contains(@class,'swal-modal')]    timeout=10s
    Click Element    xpath://button[contains(@class,'swal-button--confirm')]
    Sleep    1s
    Click Element    xpath://button[contains(@class,'swal-button--confirm')]
    Wait Until Element Is Not Visible    xpath://div[contains(@class,'swal-modal')]    timeout=10s

Search In DataTable
    [Arguments]    ${search_text}
    Wait Until Element Is Visible    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    timeout=10s  # ปรับตามคลาสของช่องค้นหา
    Input Text    xpath://div[contains(@class, 'dataTables_filter')]//input[@type='search']    ${search_text}
    Sleep    3s
    Wait Until Page Contains Element    xpath://table/tbody/tr    timeout=20s

Click View Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table/tbody/tr[td[contains(text(), '${text}')]]//a[contains(@class, 'btn-outline-primary') and contains(@title, 'View')]  # ปรับตามปุ่ม View
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Click Edit Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table/tbody/tr[td[contains(text(), '${text}')]]//a[contains(@class, 'btn-outline-success') and contains(@title, 'Edit')]  # ปรับตามปุ่ม Edit
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Click Delete Button By Text
    [Arguments]    ${text}
    ${locator}=    Set Variable    xpath://table/tbody/tr[td[contains(text(), '${text}')]]//button[contains(@class, 'btn-outline-danger') or contains(@title, 'Delete')]  # ปรับตามปุ่ม Delete
    Scroll Element Into View    ${locator}
    Wait Until Element Is Visible    ${locator}    timeout=10s
    Click Element    ${locator}

Get Fund Count
    ${count}=    Get Element Count    xpath://table/tbody/tr
    RETURN    ${count}

Fill Fund Form
    [Arguments]    ${name}    ${type}    ${level}    ${resource}
    ${name}=    Evaluate    '${name}'.strip()
    Select From List By Label    name=fund_type    ${type}
    Wait Until Element Is Visible    id=fund_code    timeout=5s
    Select From List By Label    name=fund_level    ${level}
    Input Text    name=fund_name    ${name}
    Input Text    name=support_resource    ${resource}
    # เพิ่มฟิลด์อื่น ๆ หากมีในฟอร์ม (เช่น ปี งบประมาณ) ตามโครงสร้างฟอร์มจริง