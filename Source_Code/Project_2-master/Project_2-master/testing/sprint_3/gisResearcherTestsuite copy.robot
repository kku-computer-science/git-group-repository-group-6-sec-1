*** Settings ***
Library         SeleniumLibrary
Suite Setup     Open Browser

*** Variables ***
${BROWSER}              Chrome
${REUSERNAME}           punhor1@kku.ac.th
${REPASSWORD}           123456789
${ADMINUSERNAME}        admin@gmail.com
${ADMINPASSWORD}        12345678
${INVALID_USERNAME}     raye@uk.com
${INVALID_PASSWORD}     1234567888
${Base_URL}             https://cs6sec267.cpkkuhost.com/
${DASHBOARD_URL}        https://cs6sec267.cpkkuhost.com/dashboard
${LOGIN_URL}            https://cs6sec267.cpkkuhost.com/login
${current_url}          ${EMPTY}
${LANG_DROPDOWN}    xpath=//*[@id="navbarDropdownMenuLink"]
${EN_BUTTON}    xpath=//div[@class='dropdown-menu show']//a[contains(text(), 'English')]
${TH_BUTTON}    xpath=//div[@class='dropdown-menu show']//a[contains(text(), 'ไทย')]
${CH_BUTTON}    xpath=//div[@class='dropdown-menu show']//a[contains(text(), '中文')]

*** Test Cases ***
TC01_GISResearcher_FacultyTranslation
    [Documentation]    คลิกที่ "Computer Science" จากรายการใน dropdown
    Open Browser    ${Base_URL}    ${BROWSER}
    Maximize Browser Window
    Wait Until Element Is Visible    xpath=//a[@id='navbarDropdown']    timeout=10s
    Click Element    xpath=//a[@id='navbarDropdown' and contains(text(), 'Researchers')]
    Sleep    1s  # Give time for dropdown to open
    Wait Until Element Is Visible    xpath=//ul[@class='dropdown-menu show']    timeout=10s
    # Ensure dropdown menu is visible
    Scroll Element Into View    xpath=//ul[@class='dropdown-menu show']  # Scroll to the dropdown menu if necessary
    Sleep    1s
    Click Element    xpath=//a[@class='dropdown-item' and contains(text(), 'Geo-Informatics')]  # Click on the "Computer Science" item in the dropdown
    Sleep    2s
    Page Should Contain    text=Geo-Informatics
    Page Should Contain    text=Researchers
    Page Should Contain    text=Search:
    Page Should Contain    text=Research interests

    Change Language To Thai

    Page Should Contain    text=ภูมิสารสนเทศศาสตร์
    Page Should Contain    text=นักวิจัย
    Page Should Contain    text=ค้นหา:
    ${placeholder}=    Get Element Attribute    xpath=//input[@name='textsearch']    placeholder
    Should Be Equal As Strings    ${placeholder}    ความสนใจในการวิจัย

    Change Language To Chinese

    Page Should Contain    text=地理信息学
    Page Should Contain    text=研究人员
    Page Should Contain    text=搜索:
    ${placeholder}=    Get Element Attribute    xpath=//input[@name='textsearch']    placeholder
    Should Be Equal As Strings    ${placeholder}    研究兴趣

*** Test Cases ***
TC02_GISResearcher_SearchTranslation
    [Documentation]    ตรวจสอบข้อมูลใน card ของอาจารย์
    Change Language To Thai
    # Wait for the card to be visible
    Wait Until Element Is Visible    xpath=//div[@class='card mb-3']    timeout=10s

    # Verify professor's name
    ${name}=    Get Text    xpath=//h5[@class='card-title']
    Should Be Equal As Strings    ${name}    ศ.ดร. ศาสตรา วงศ์ธนวสุ

    # Verify academic title
    ${title}=    Get Text    xpath=//h5[@class='card-title-2']
    Should Be Equal As Strings    ${title}    ศาสตราจารย์

    # Verify expertise fields
    Page Should Contain    การวิเคราะห์ข้อมูลมหัต
    Page Should Contain    การรับภาพของคอมพิวเตอร์
    Page Should Contain    เซลลูลาร์ออโตมาตา

*** Keywords ***
Open Browserr
    Open Browser    ${Base_URL}    ${BROWSER}
    Maximize Browser Window
    Click Element   xpath=//a[contains(@class, 'btn-solid-sm')]
    ${handles}=    Get Window Handles
    Switch Window    ${handles}[1]    # สลับไปยังแท็บใหม่
    Wait Until Location Contains    /login    3s
    ${current_url}=    Get Location
    Should Be Equal As Strings    ${current_url}    ${LOGIN_URL}

Login Input Correct
    Input Text    id=username    ${REUSERNAME}
    Input Text    id=password    ${REPASSWORD}
    Click Element   xpath=//button[@type='submit']
    Wait Until Location Contains    ${DASHBOARD_URL}    5s

Login Input Correct Admin
    Input Text    id=username    ${ADMINUSERNAME}
    Input Text    id=password    ${ADMINPASSWORD}
    Click Element   xpath=//button[@type='submit']
    Wait Until Location Contains    ${DASHBOARD_URL}    5s

Login Input Incorrect
    Input Text    id=username    ${INVALID_USERNAME}
    Input Text    id=password    ${INVALID_PASSWORD}
    Click Element   xpath=//button[@type='submit']
    Wait Until Location Contains    ${LOGIN_URL}    5s

Click Logout
    ${current_url}=    Get Location
    Log To Console    Current URL before logout: ${current_url}
    Wait Until Page Contains Element    xpath=//a[@class='nav-link' and .//i[contains(@class, 'mdi-logout')]]    8s
    Click Element    xpath=//a[@class='nav-link' and .//i[contains(@class, 'mdi-logout')]]
    Wait Until Location Contains    ${LOGIN_URL}    8s
    Log To Console    Logged out successfully

Reset Language To English
    Mouse Over    ${LANG_DROPDOWN}
    Sleep    1s
    Click Element    ${LANG_DROPDOWN}
    Wait Until Element Is Visible    ${EN_BUTTON}    timeout=5s
    Click Element    ${EN_BUTTON}
    Sleep    3s

Change Language To English
    Go To    ${Base_URL}/lang/en
    Sleep    2s
    Reload Page
    Wait Until Page Contains    Login    5s

Change Language To Thai
    Go To    ${Base_URL}/lang/th
    Sleep    2s
    Reload Page
    Wait Until Page Contains    เข้าสู่ระบบ    5s

Change Language To Chinese
    Go To    ${Base_URL}/lang/zh
    Sleep    2s
    Reload Page
    Wait Until Page Contains    登入    5s

Verify Login Success
    [Arguments]    ${expected_text}
    Page Should Contain    ${expected_text}    10s
    Log To Console    Verified text: ${expected_text}
