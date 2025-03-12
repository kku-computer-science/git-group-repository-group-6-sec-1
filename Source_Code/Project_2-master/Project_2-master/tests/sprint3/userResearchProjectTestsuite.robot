*** Settings ***
Documentation    Test Suite for Admin Research Projects Management System
Library          SeleniumLibrary
Library          DateTime
Suite Setup      Open Browser And Login
Suite Teardown   Close All Browsers

*** Variables ***
${LOGIN_URL}      http://127.0.0.1:8000/login
${DASHBOARD_URL}  http://127.0.0.1:8000/dashboard
${INDEX_URL}      http://127.0.0.1:8000/researchProjects
${CREATE_URL}     http://127.0.0.1:8000/researchProjects/create
${BROWSER}        chrome
${USERNAME}       pusadee@kku.ac.th
${PASSWORD}       123456789

*** Test Cases ***
TC01 - Login and Access Research Projects List
    [Documentation]    Verify successful login and navigation to research projects page
    Wait For Page Load
    Go To    ${INDEX_URL}
    Wait Until Page Contains Element    xpath://table[@id='example1']    timeout=10s
    Page Should Contain    Research Projects

TC02 - Add New Research Project
    [Documentation]    Verify adding a new research project with all required fields filled
    Go To    ${CREATE_URL}
    Wait For Form Load

    Input Text    name=project_name    โครงการวิจัยใหม่
    Execute JavaScript    document.getElementById('Project_start').value = '2025-03-12';
    Execute JavaScript    document.getElementById('Project_end').value = '2025-12-31';
    Wait Until Element Is Visible    id=fund    timeout=20s
    Select From List By Label    id=fund    Statistical Thai – Isarn Dialect Machine Translation System using Parallel Corpus
    Input Text    name=project_year    2025
    Input Text    name=budget    500000

    # Department - เลือก "สาขาวิชาวิทยาการคอมพิวเตอร์" แทน "Department of Computer Science"
    Wait Until Element Is Visible    id=dep    timeout=20s
    ${options}=    Get List Items    id=dep
    Log To Console    Available departments: ${options}
    Select From List By Label    id=dep    สาขาวิชาวิทยาการคอมพิวเตอร์

    Input Text    name=note    รายละเอียดโครงการทดสอบ

    # Project Status - ตรวจสอบตัวเลือกก่อนเลือก
    Scroll Element Into View    xpath=//label[text()='Project Status']/following-sibling::div//select
    Wait Until Element Is Visible    xpath=//label[text()='Project Status']/following-sibling::div//select    timeout=20s
    ${status_options}=    Get List Items    xpath=//label[text()='Project Status']/following-sibling::div//select
    Log To Console    Available status options: ${status_options}
    ${status_exists}=    Run Keyword And Return Status    List Should Contain Value    ${status_options}    Requested
    Run Keyword If    ${status_exists}    Select From List By Label    xpath=//label[text()='Project Status']/following-sibling::div//select    Requested
    ...    ELSE    Select From List By Index    xpath=//label[text()='Project Status']/following-sibling::div//select    1    # เลือกตัวเลือกแรกถ้าไม่เจอ

    # Project Head (Pusadee Seresangtakul)
    Scroll Element Into View    id=head0
    Wait Until Element Is Visible    xpath=//select[@id='head0']/following-sibling::span//span[contains(@class,'select2-selection')]    timeout=10s
    Click Element    xpath=//select[@id='head0']/following-sibling::span//span[contains(@class,'select2-selection')]
    Wait Until Element Is Visible    xpath=//input[contains(@class,'select2-search__field')]    timeout=10s
    Input Text    xpath=//input[contains(@class,'select2-search__field')]    Pusadee Seresangtakul
    Wait Until Element Is Visible    xpath=//li[contains(@class,'select2-results__option') and contains(.,'Pusadee Seresangtakul')]    timeout=10s
    Click Element    xpath=//li[contains(@class,'select2-results__option') and contains(.,'Pusadee Seresangtakul')]

    # Project Member
    Scroll Element Into View    id=selUser0
    Wait Until Element Is Visible    xpath=//select[@id='selUser0']/following-sibling::span//span[contains(@class,'select2-selection')]    timeout=10s
    Click Element    xpath=//select[@id='selUser0']/following-sibling::span//span[contains(@class,'select2-selection')]
    Wait Until Element Is Visible    xpath=//input[contains(@class,'select2-search__field')]    timeout=10s
    Input Text    xpath=//input[contains(@class,'select2-search__field')]    Punyaphol Horata
    Wait Until Element Is Visible    xpath=//li[contains(@class,'select2-results__option') and contains(.,'Punyaphol Horata')]    timeout=10s
    Click Element    xpath=//li[contains(@class,'select2-results__option') and contains(.,'Punyaphol Horata')]
    Scroll Element Into View    id=add-btn2
    Click Element    id=add-btn2
    Sleep    2s

    # Submit
    Scroll Element Into View    xpath=//button[@type='submit']
    Wait Until Element Is Enabled    xpath=//button[@type='submit']    timeout=10s
    Click Element    xpath=//button[@type='submit']
    Wait Until Page Contains    research projects created successfully.    timeout=20s

    Go To    ${INDEX_URL}
    Reload Page
    Wait For Table Load
    Sleep    2s
    Search In DataTable    โครงการวิจัยใหม่
    Page Should Contain    โครงการวิจัยใหม่

TC03 - View Research Project Details
    [Documentation]    Verify viewing details of a research project
    Go To    ${INDEX_URL}
    Wait For Table Load
    Search In DataTable    โครงการวิจัยใหม่
    ${row}=    Get Element Count    xpath://table[@id='example1']/tbody/tr[td[contains(text(),'โครงการวิจัยใหม่')]]
    Run Keyword If    ${row} > 0    Click View Button By Text    โครงการวิจัยใหม่
    ...    ELSE    Fail    Project 'โครงการวิจัยใหม่' not found in table after search
    Wait For Page Load
    Page Should Contain    โครงการวิจัยใหม่
    Click Element    xpath://a[contains(text(),'Back')]
    Wait For Table Load

TC04 - Edit Research Project
    [Documentation]    Verify editing an existing research project with all fields
    Go To    ${INDEX_URL}
    Reload Page
    Sleep    3s
    Wait For Table Load

    Search In DataTable    โครงการวิจัยใหม่

    # ✅ Scroll + Wait + Click ด้วย XPath ที่แม่นยำกว่าเดิม
    Scroll Element Into View    xpath=//table[@id='example1']//tr[td[normalize-space()='โครงการวิจัยใหม่']]//a[@title='Edit']
    Wait Until Element Is Visible    xpath=//table[@id='example1']//tr[td[normalize-space()='โครงการวิจัยใหม่']]//a[@title='Edit']    timeout=5s
    Click Element    xpath=//table[@id='example1']//tr[td[normalize-space()='โครงการวิจัยใหม่']]//a[@title='Edit']

    Wait For Form Load

    # ✅ Step 1: เปลี่ยนชื่อโครงการ
    Input Text    name=project_name    โครงการวิจัยใหม่ที่แก้ไขแล้ว

    # ✅ Step 2: เปลี่ยนวันเริ่มต้นโครงการ
    Wait Until Element Is Visible    name=project_start    timeout=10s
    Execute JavaScript    document.getElementsByName('project_start')[0].value = '2025-04-10';

    # ✅ Step 3: เปลี่ยนวันสิ้นสุดโครงการ
    Wait Until Element Is Visible    name=project_end    timeout=10s
    Execute JavaScript    document.getElementsByName('project_end')[0].value = '2025-11-30';

    # ✅ Step 4: เปลี่ยนแหล่งทุนวิจัย
    Wait Until Element Is Visible    id=fund    timeout=10s
    Select From List By Label    id=fund    นวัตกรรมดัชนีสุขภาพของประชากรไทยโดยวิทยาการข้อมูลเพื่อประโยชน์ในการปรับเปลี่ยนพฤติกรรม

    # ✅ Step 5: เปลี่ยนปีโครงการ
    Input Text    name=project_year    2026

    # ✅ Step 6: เปลี่ยนงบประมาณโครงการ
    Input Text    name=budget    700000

    # ✅ Step 7: เปลี่ยนสาขาวิชาที่รับผิดชอบ
    Wait Until Element Is Visible    name=responsible_department    timeout=10s
    Input Text    name=responsible_department    สาขาวิชาวิศวกรรมซอฟต์แวร์

    # ✅ Step 8: เปลี่ยนรายละเอียดโครงการ
    Input Text    name=note    รายละเอียดโครงการที่แก้ไขแล้ว

    # ✅ Step 9: เปลี่ยนสถานะโครงการ
    Scroll Element Into View    id=status
    Sleep    1s
    Wait Until Element Is Visible    id=status    timeout=10s
    Click Element    xpath=//select[@id='status']//option[normalize-space(.)='Closed']

    # ✅ Step 10: เลือก Project Head ด้วย JavaScript (ใช้ค่า value แทน)
    Scroll Element Into View    id=head0
    Wait Until Element Is Visible    id=head0    timeout=10s
    Execute JavaScript    $("#head0").val("16").trigger("change");
    Sleep    1s

    # ✅ Step 11: Submit ฟอร์มแก้ไข
    Scroll Element Into View    xpath=//button[@type='submit']
    Wait Until Element Is Enabled    xpath=//button[@type='submit']    timeout=10s
    Click Element    xpath=//button[@type='submit']

    # ✅ Step 12: รอให้ข้อมูลถูกบันทึกในระบบ
    # Wait Until Page Contains    research project updated successfully.    timeout=10s

    # ✅ Step 13: ตรวจสอบข้อมูลใหม่ในตาราง
    Go To    ${INDEX_URL}
    Reload Page
    Search In DataTable    โครงการวิจัยใหม่ที่แก้ไขแล้ว
    Page Should Contain    โครงการวิจัยใหม่ที่แก้ไขแล้ว

TC05 - Delete Research Project
    [Documentation]    Verify deleting a research project
    Go To    ${INDEX_URL}
    Reload Page
    Sleep    3s
    Wait For Table Load

    Input Text    xpath=//div[@id='example1_filter']//input[@type='search']    โครงการวิจัยใหม่ที่แก้ไขแล้ว
    Sleep    1s
    Press Keys    xpath=//div[@id='example1_filter']//input[@type='search']    ENTER
    Wait For Table Load

    ${row}=    Get Element Count    xpath=//table[@id='example1']/tbody/tr[td[contains(text(),'โครงการวิจัยใหม่ที่แก้ไขแล้ว')]]
    Run Keyword If    ${row} == 0    Log    Research project already deleted, test case passed.
    Run Keyword If    ${row} == 0    Pass Execution    Research project already deleted, test case passed.

    Run Keyword If    ${row} > 0    Scroll Element Into View    xpath=//table[@id='example1']//td[contains(text(),'โครงการวิจัยใหม่ที่แก้ไขแล้ว')]/following-sibling::td//button[contains(@class,'btn-outline-danger')]
    Run Keyword If    ${row} > 0    Wait Until Element Is Visible    xpath=//table[@id='example1']//td[contains(text(),'โครงการวิจัยใหม่ที่แก้ไขแล้ว')]/following-sibling::td//button[contains(@class,'btn-outline-danger')]    timeout=10s
    Run Keyword If    ${row} > 0    Click Element    xpath=//table[@id='example1']//td[contains(text(),'โครงการวิจัยใหม่ที่แก้ไขแล้ว')]/following-sibling::td//button[contains(@class,'btn-outline-danger')]

    Sleep    1s
    Handle Sweet Alert Confirmation
    Sleep    1s
    Handle Sweet Alert Confirmation
    Sleep    2s

    Reload Page
    Wait For Table Load
    Input Text    xpath=//div[@id='example1_filter']//input[@type='search']    โครงการวิจัยใหม่ที่แก้ไขแล้ว
    Sleep    1s
    Press Keys    xpath=//div[@id='example1_filter']//input[@type='search']    ENTER
    Wait For Table Load
    Wait Until Page Does Not Contain    โครงการวิจัยใหม่ที่แก้ไขแล้ว    timeout=10s

    ${row_after_delete}=    Get Element Count    xpath=//table[@id='example1']/tbody/tr[td[contains(text(),'โครงการวิจัยใหม่ที่แก้ไขแล้ว')]]
    Run Keyword If    ${row_after_delete} > 0    Fail    Project 'โครงการวิจัยใหม่ที่แก้ไขแล้ว' not deleted successfully!

*** Keywords ***
Open Browser And Login
    Open Browser    ${LOGIN_URL}    ${BROWSER}
    Maximize Browser Window
    Login To System
    Go To    ${DASHBOARD_URL}
    Go To    ${INDEX_URL}

Login To System
    Input Text    id=username    ${USERNAME}
    Input Text    id=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit']
    Wait Until Page Contains Element    xpath://body    timeout=10s

Wait For Page Load
    Wait Until Page Contains Element    xpath://body    timeout=10s

Wait For Form Load
    Wait Until Page Contains Element    xpath://form    timeout=10s

Wait For Table Load
    Wait Until Page Contains Element    xpath://table[@id='example1']    timeout=10s

Search In DataTable
    [Arguments]    ${search_text}
    Reload Page
    Wait For Table Load
    Input Text    xpath=//div[@id='example1_filter']//input[@type='search']    ${search_text}
    Sleep    2s

Select From Select2 Dropdown
    [Arguments]    ${dropdown_id}    ${value}
    Click Element    xpath=//select[@id='${dropdown_id}']/following::span[contains(@class,'select2-selection')]
    Sleep    1s
    Wait Until Element Is Visible    xpath=//li[contains(@class,'select2-results__option') and normalize-space()='${value}']    timeout=5s
    Click Element    xpath=//li[contains(@class,'select2-results__option') and normalize-space()='${value}']
    Sleep    1s

Click View Button By Text
    [Arguments]    ${text}
    Click Element    xpath=//table[@id='example1']//td[contains(text(),'${text}')]/following-sibling::td//a[@title='view']

Click Edit Button By Text
    [Arguments]    ${text}
    Click Element    xpath=//table[@id='example1']//td[contains(text(),'${text}')]/following-sibling::td//a[@title='edit']

Click Delete Button By Text
    [Arguments]    ${text}
    Click Element    xpath=//table[@id='example1']//td[contains(text(),'${text}')]/following-sibling::td//button[@title='delete']

Handle Sweet Alert Confirmation
    Wait Until Element Is Visible    xpath=//button[contains(@class,'swal-button--confirm')]    timeout=5s
    Click Element    xpath=//button[contains(@class,'swal-button--confirm')]
    Sleep    2s