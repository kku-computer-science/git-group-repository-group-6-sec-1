*** Settings ***
Library    SeleniumLibrary
Library    Process

*** Variables ***
${BROWSER}    Chrome
${URL}        https://cs6sec267.cpkkuhost.com/
${USERNAME_FIELD}    id=username
${USERNAME}    admin@gmail.com
${PASSWORD_FIELD}    id=password
${PASSWORD}    12345678
${LOGIN_URL}    ${URL}/login
${WELCOME_TEXT}    Hello  admin - -

*** Test Cases ***
TC01_S3_LoginandViewUsersAdmin
    [Documentation]    Test case to login and view users
    Open Browser To Form Page
    Input Text Into Username Field
    Input Text Into Password Field
    Submit Login Form
    Wait For Page Load After Login
    Click User Sidebar Icon
    Sleep    5s

TC02_S3_ViewUsersAdmin
    [Documentation]    Test case to view users
    Execute JavaScript    window.scrollBy({top: 800, behavior: 'smooth'});    # เลื่อนลงช้า ๆ 500px
    Sleep    5s
    Wait Until Element Is Visible    xpath=//*[@id="example1_paginate"]/ul/li[3]/a    timeout=5s
    Click Element    xpath=//*[@id="example1_paginate"]/ul/li[3]/a
    Sleep    5s

    Execute JavaScript    window.scrollBy({top: -400, behavior: 'smooth'});    # เลื่อนลงช้า ๆ 500px
    Sleep   5s
    Click Element    xpath=//a[contains(@class, 'btn-outline-primary') and contains(@href, '/users/16')]
    Sleep    3s
    Execute JavaScript    window.scrollBy({top: -400, behavior: 'smooth'});    # เลื่อนลงช้า ๆ 500px
    Sleep    2s

    Wait Until Element Is Visible    xpath=/html/body/div/div/div/div/div/div/div/div/a    timeout=5s
    Click Element    xpath=/html/body/div/div/div/div/div/div/div/div/a

TC03_S3_EditUsersAdmin
    [Documentation]    Test case to edit users
    Go To    ${URL}users/16/edit
    Execute JavaScript    window.scrollBy({top: 600, behavior: 'smooth'});    # เลื่อนลงช้า ๆ 500px
    Sleep    1s
    Execute JavaScript    window.scrollBy({top: 600, behavior: 'smooth'});    # เลื่อนลงช้า ๆ 500px
    Sleep    1s
    Execute JavaScript    window.scrollBy({top: 220, behavior: 'smooth'});    # เลื่อนลงช้า ๆ 500px
    Sleep    1s


    Wait Until Element Is Visible    xpath=//*[@id="bachelor-tab"]    timeout=5s
    Click Element    xpath=//*[@id="bachelor-tab"]

    Sleep    3s

    Wait Until Element Is Visible    xpath=//*[@id="master-tab"]    timeout=5s
    Click Element    xpath=//*[@id="master-tab"]

    Sleep    3s

    Wait Until Element Is Visible    xpath=//*[@id="doctoral-tab"]    timeout=5s
    Click Element    xpath=//*[@id="doctoral-tab"]

    Wait Until Element Is Visible    xpath=//*[@id="doctoral_year_th"]    timeout=5s
    Input Text    xpath=//*[@id="doctoral_year_th"]    2549

    Execute JavaScript    window.scrollBy({top: 150, behavior: 'smooth'});    # เลื่อนลงช้า ๆ 500px
    Sleep    1s

    Wait Until Element Is Visible    xpath=/html/body/div/div/div/div/div/div/div/div/button    timeout=5s
    Click Element    xpath=/html/body/div/div/div/div/div/div/div/div/button

    Go To    url=${URL}users/16
    Sleep    5s

    Close Browser



*** Keywords ***
Open Browser To Form Page
    Open Browser    ${URL}    ${BROWSER}
    Maximize Browser Window
    Click Element    class=btn-solid-sm
    Sleep    2s
    Switch Window  title:Login
    Wait Until Element Is Visible    ${USERNAME_FIELD}    timeout=20s

Input Text Into Username Field
    Input Text    ${USERNAME_FIELD}    ${USERNAME}

Input Text Into Password Field
    Input Text    ${PASSWORD_FIELD}    ${PASSWORD}

Submit Login Form
    Click Button    xpath=//button[@type='submit']
    Sleep    2s

Wait For Page Load After Login
    Wait Until Location Contains    /dashboard    timeout=30s

Verify Welcome Message
    Page Should Contain    ${WELCOME_TEXT}

Click User Sidebar Icon
    Wait Until Element Is Visible    xpath=//i[contains(@class, 'menu-icon mdi mdi-account-multiple-outline')]    timeout=10s
    Click Element    xpath=//i[contains(@class, 'menu-icon mdi mdi-account-multiple-outline')]


