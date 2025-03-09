*** Settings ***
Documentation   Test suite for Admin Profile Page
Library         SeleniumLibrary

*** Variables ***
${MAIN_PAGE_URL}    http://127.0.0.1:8000/
${LOGIN_URL}        http://127.0.0.1:8000/login 
${USERNAME}         admin@gmail.com
${PASSWORD}         12345678
${BROWSER}          Edge
${DELAY}           .5s

*** Test Cases ***
Start At Main Page And Go To Login
    Open Browser    ${MAIN_PAGE_URL}    ${BROWSER}
    Maximize Browser Window
    Click Link    xpath=//a[contains(text(), 'Login')]
    Sleep    ${DELAY}
    Wait Until Page Contains    Login    timeout=5s
    Switch Window    NEW  # Switch to the newly opened tab
    Sleep    ${DELAY}

Admin User Can Login Successfully
    Input Text      name=username    ${USERNAME}
    Input Text      name=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit' and contains(text(), 'Login')]
    Sleep    ${DELAY}
    Wait Until Page Contains    Dashboard    timeout=5s
    Sleep    ${DELAY}

Navigate To Profile Page
    Wait Until Element Is Visible    xpath=//a[@class='nav-link ' and contains(@href, '/profile')]
    Click Link    xpath=//a[@class='nav-link ' and contains(@href, '/profile')]
    Sleep    ${DELAY}

Click To Account Tab
    Wait Until Element Is Visible    xpath=//a[@id='account-tab' and contains(@class, 'nav-link')]
    Click Link    xpath=//a[@id='account-tab' and contains(@class, 'nav-link')]
    Sleep    ${DELAY}

    # Switch to chinese
    Wait Until Element Is Visible    xpath=//a[@id='navbarDropdownMenuLink' and contains(@class, 'dropdown-toggle')]
    Click Element    xpath=//a[@id='navbarDropdownMenuLink' and contains(@class, 'dropdown-toggle')]
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/lang/zh')]
    Click Link    xpath=//a[contains(@href, '/lang/zh')]
    Sleep    ${DELAY}
    Wait Until Page Contains    中国    timeout=5s
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[@id='account-tab' and contains(@class, 'nav-link')]
    Click Link    xpath=//a[@id='account-tab' and contains(@class, 'nav-link')]
    Sleep    ${DELAY}

    # Switch to Thai
    Wait Until Element Is Visible    xpath=//a[@id='navbarDropdownMenuLink' and contains(@class, 'dropdown-toggle')]
    Click Element    xpath=//a[@id='navbarDropdownMenuLink' and contains(@class, 'dropdown-toggle')]
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/lang/th')]
    Click Link    xpath=//a[contains(@href, '/lang/th')]
    Sleep    ${DELAY}
    Wait Until Page Contains    ไทย    timeout=5s
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[@id='account-tab' and contains(@class, 'nav-link')]
    Click Link    xpath=//a[@id='account-tab' and contains(@class, 'nav-link')]
    Sleep    ${DELAY}

    # Switch back to English
    Wait Until Element Is Visible    xpath=//a[@id='navbarDropdownMenuLink' and contains(@class, 'dropdown-toggle')]
    Click Element    xpath=//a[@id='navbarDropdownMenuLink' and contains(@class, 'dropdown-toggle')]
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/lang/en')]
    Click Link    xpath=//a[contains(@href, '/lang/en')]
    Sleep    ${DELAY}
    Wait Until Page Contains    English    timeout=5s
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[@id='account-tab' and contains(@class, 'nav-link')]
    Click Link    xpath=//a[@id='account-tab' and contains(@class, 'nav-link')]
    Sleep    ${DELAY}
    
    Wait Until Page Contains    User Profile    timeout=5s
    Sleep    ${DELAY}

*** Keywords ***
Close Browser Session
    Close Browser