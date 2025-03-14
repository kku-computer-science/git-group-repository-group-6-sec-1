*** Settings ***
Library    SeleniumLibrary

*** Variables ***
${BROWSER}    Chrome
${URL}        https://cs6sec267.cpkkuhost.com/
${USERNAME_FIELD}    id=username
${USERNAME}    pusadee@kku.ac.th
${PASSWORD_FIELD}    id=password
${PASSWORD}    123456789
${LOGIN_URL}    ${URL}/login
${WELCOME_TEXT}    Hello Asst. Prof. Dr. Pusadee Seresangtakul -

*** Test Cases ***
TC01_S3_LoginandViewUsers
    [Documentation]    Test case to login and view users
    Open Browser To Form Page
    Input Text Into Username Field
    Input Text Into Password Field
    Submit Login Form
    Wait For Page Load After Login
    Verify Welcome Message
    Click User Sidebar Icon
    Sleep    5s
    [Teardown]    Close Browser

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
    Wait Until Element Is Visible    xpath=//i[contains(@class, 'mdi-account-circle-outline')]    timeout=10s
    Click Element    xpath=//i[contains(@class, 'mdi-account-circle-outline')]


