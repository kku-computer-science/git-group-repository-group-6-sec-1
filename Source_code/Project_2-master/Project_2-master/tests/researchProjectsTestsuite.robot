*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser To Research Project
Suite Teardown  Close All Browsers

*** Variables ***
${URL}              http://127.0.0.1:8000
${BROWSER}          Chrome
${RESEARCH_PROJECT_URL}    http://127.0.0.1:8000/researchproject

*** Test Cases ***
TC22_ResearcherProject_DetailTableTranslation
    [Documentation]    ตรวจสอบภาษาข้อมูลต่างๆ ในหน้าโครงการวิจัย/บริการวิชาการ
    Go To    ${RESEARCH_PROJECT_URL}
    Wait Until Page Contains    โครงการบริการวิชาการ/ โครงการวิจัย    timeout=10s
    Check Research Project Translations

TC23_ResearcherProject_TableTranslations
    [Documentation]    ตรวจสอบภาษาในตารางโครงการวิจัย/บริการวิชาการ และเปิดให้ครบทุกหน้า
    Go To    ${RESEARCH_PROJECT_URL}
    Wait Until Page Contains    โครงการบริการวิชาการ/ โครงการวิจัย    timeout=10s
    Check Research Project Table Translations
    Navigate All Table Pages

*** Keywords ***
Open Browser To Research Project
    Open Browser    ${RESEARCH_PROJECT_URL}    ${BROWSER}
    Maximize Browser Window

Switch Language
    [Arguments]    ${lang}
    Go To    ${URL}/lang/${lang}
    Wait Until Page Contains Element    xpath://body    timeout=10s
    Log To Console    Switched to language: ${lang}

Check Text Case Insensitive
    [Arguments]    ${locator}    ${expected_text}
    ${status}=    Run Keyword And Return Status    Wait Until Element Is Visible    ${locator}    timeout=10s
    Run Keyword If    not ${status}    Log To Console    Element ${locator} not visible after 10s
    ${actual_text}=    Get Text    ${locator}
    Log To Console    Actual text found at ${locator}: ${actual_text}
    Run Keyword If    '${actual_text}' == ''    Fail    Empty text found at ${locator}, expected '${expected_text}'
    Should Be Equal As Strings    ${actual_text}    ${expected_text}    ignore_case=True

Check Research Project Translations
    Set Selenium Timeout    10s
    # Thai
    Switch Language    th
    Wait Until Element Is Visible    xpath://p    timeout=10s
    Check Text Case Insensitive    xpath://p    โครงการบริการวิชาการ/ โครงการวิจัย
    Check Text Case Insensitive    xpath://table[@id='example1']//th[1]    ลำดับ
    Check Text Case Insensitive    xpath://table[@id='example1']//th[2]    ปี
    Check Text Case Insensitive    xpath://table[@id='example1']//th[3]    ชื่อโครงการ
    Check Text Case Insensitive    xpath://table[@id='example1']//th[4]    รายละเอียด
    Check Text Case Insensitive    xpath://table[@id='example1']//th[5]    ผู้รับผิดชอบโครงการ
    Check Text Case Insensitive    xpath://table[@id='example1']//th[6]    สถานะ
    # English (สมมติว่าแปลตามบริบท)
    Switch Language    en
    Wait Until Element Is Visible    xpath://p    timeout=10s
    Check Text Case Insensitive    xpath://p    Academic Service Projects/ Research Projects
    Check Text Case Insensitive    xpath://table[@id='example1']//th[1]    No.
    Check Text Case Insensitive    xpath://table[@id='example1']//th[2]    Year
    Check Text Case Insensitive    xpath://table[@id='example1']//th[3]    Project Name
    Check Text Case Insensitive    xpath://table[@id='example1']//th[4]    Details
    Check Text Case Insensitive    xpath://table[@id='example1']//th[5]    Project Leader
    Check Text Case Insensitive    xpath://table[@id='example1']//th[6]    Status
    # Chinese (สมมติว่าแปลตามบริบท)
    Switch Language    zh
    Wait Until Element Is Visible    xpath://p    timeout=10s
    Check Text Case Insensitive    xpath://p    学术服务项目/研究项目
    Check Text Case Insensitive    xpath://table[@id='example1']//th[1]    编号
    Check Text Case Insensitive    xpath://table[@id='example1']//th[2]    年份
    Check Text Case Insensitive    xpath://table[@id='example1']//th[3]    项目名称
    Check Text Case Insensitive    xpath://table[@id='example1']//th[4]    详情
    Check Text Case Insensitive    xpath://table[@id='example1']//th[5]    项目负责人
    Check Text Case Insensitive    xpath://table[@id='example1']//th[6]    状态

Check Research Project Table Translations
    Set Selenium Timeout    10s
    # Thai
    Switch Language    th
    Wait Until Element Is Visible    xpath://table[@id='example1']    timeout=10s
    Check Text Case Insensitive    xpath://table[@id='example1']//th[1]    ลำดับ
    Check Text Case Insensitive    xpath://table[@id='example1']//th[2]    ปี
    Check Text Case Insensitive    xpath://table[@id='example1']//th[3]    ชื่อโครงการ
    Check Text Case Insensitive    xpath://table[@id='example1']//th[4]    รายละเอียด
    Check Text Case Insensitive    xpath://table[@id='example1']//th[5]    ผู้รับผิดชอบโครงการ
    Check Text Case Insensitive    xpath://table[@id='example1']//th[6]    สถานะ
    # Check details in table rows (example, adjust based on actual content)
    ${rows}=    Get WebElements    xpath://table[@id='example1']//tbody/tr
    FOR    ${row}    IN    @{rows}
        ${cells}=    Get WebElements    xpath://table[@id='example1']//tbody/tr[${row}]/td
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), 'ระยะเวลาโครงการ')]    ระยะเวลาโครงการ
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), 'ประเภททุนวิจัย')]    ประเภททุนวิจัย
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), 'หน่วยงานที่สนันสนุนทุน')]    หน่วยงานที่สนันสนุนทุน
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), 'หน่วยงานที่รับผิดชอบ')]    หน่วยงานที่รับผิดชอบ
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), 'งบประมาณที่ได้รับจัดสรร')]    งบประมาณที่ได้รับจัดสรร
        # Check status badges
        ${status}=    Get Text    xpath://table[@id='example1']//tbody/tr[${row}]/td[6]//label
        Run Keyword If    '${status}' == 'ยื่นขอ'    Log To Console    Status Thai: ยื่นขอ
        Run Keyword If    '${status}' == 'ดำเนินการ'    Log To Console    Status Thai: ดำเนินการ
        Run Keyword If    '${status}' == 'ปิดโครงการ'    Log To Console    Status Thai: ปิดโครงการ
    END
    # English
    Switch Language    en
    Check Text Case Insensitive    xpath://table[@id='example1']//th[1]    No.
    Check Text Case Insensitive    xpath://table[@id='example1']//th[2]    Year
    Check Text Case Insensitive    xpath://table[@id='example1']//th[3]    Project Name
    Check Text Case Insensitive    xpath://table[@id='example1']//th[4]    Details
    Check Text Case Insensitive    xpath://table[@id='example1']//th[5]    Project Leader
    Check Text Case Insensitive    xpath://table[@id='example1']//th[6]    Status
    FOR    ${row}    IN    @{rows}
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), 'Project Duration')]    Project Duration
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), 'Research Fund Type')]    Research Fund Type
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), 'Funding Agency')]    Funding Agency
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), 'Responsible Department')]    Responsible Department
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), 'Allocated Budget')]    Allocated Budget
        ${status}=    Get Text    xpath://table[@id='example1']//tbody/tr[${row}]/td[6]//label
        Run Keyword If    '${status}' == 'Submitted'    Log To Console    Status English: Submitted
        Run Keyword If    '${status}' == 'In Progress'    Log To Console    Status English: In Progress
        Run Keyword If    '${status}' == 'Closed'    Log To Console    Status English: Closed
    END
    # Chinese
    Switch Language    zh
    Check Text Case Insensitive    xpath://table[@id='example1']//th[1]    编号
    Check Text Case Insensitive    xpath://table[@id='example1']//th[2]    年份
    Check Text Case Insensitive    xpath://table[@id='example1']//th[3]    项目名称
    Check Text Case Insensitive    xpath://table[@id='example1']//th[4]    详情
    Check Text Case Insensitive    xpath://table[@id='example1']//th[5]    项目负责人
    Check Text Case Insensitive    xpath://table[@id='example1']//th[6]    状态
    FOR    ${row}    IN    @{rows}
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), '项目期限')]    项目期限
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), '研究基金类型')]    研究基金类型
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), '资助机构')]    资助机构
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), '负责部门')]    负责部门
        Check Text Case Insensitive    xpath://table[@id='example1']//tbody/tr[${row}]/td[4]//span[contains(text(), '分配预算')]    分配预算
        ${status}=    Get Text    xpath://table[@id='example1']//tbody/tr[${row}]/td[6]//label
        Run Keyword If    '${status}' == '提交'    Log To Console    Status Chinese: 提交
        Run Keyword If    '${status}' == '进行中'    Log To Console    Status Chinese: 进行中
        Run Keyword If    '${status}' == '已关闭'    Log To Console    Status Chinese: 已关闭
    END

Navigate All Table Pages
    Set Selenium Timeout    10s
    Wait Until Element Is Visible    xpath://table[@id='example1']    timeout=10s
    ${page_count}=    Get Element Count    xpath://ul[@class='pagination']/li
    FOR    ${i}    IN RANGE    1    ${page_count}+1
        ${is_active}=    Run Keyword And Return Status    Element Should Be Visible    xpath://ul[@class='pagination']/li[${i}]/a[contains(@class, 'active')]
        Run Keyword If    not ${is_active}    Click Element    xpath://ul[@class='pagination']/li[${i}]/a
        Wait Until Element Is Visible    xpath://table[@id='example1']//tbody/tr    timeout=10s
        ${rows}=    Get WebElements    xpath://table[@id='example1']//tbody/tr
        FOR    ${row}    IN    @{rows}
            # ตรวจสอบว่าข้อมูลในแต่ละแถวถูกต้อง (สามารถเพิ่มตรวจสอบเพิ่มเติมตามความเหมาะสม)
            Log To Console    Checking row on page ${i}
        END
    END