*** Settings ***
Documentation   Test suite for Admin Profile Page
Library         SeleniumLibrary

*** Variables ***
${MAIN_PAGE_URL}    http://127.0.0.1:8000/
${LOGIN_URL}        http://127.0.0.1:8000/login 
${USERNAME}         admin@gmail.com
${PASSWORD}         12345678
${BROWSER}          Firefox
${DELAY}           1s

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

Click Manage Publications
    Click Link    xpath=//a[@class='nav-link' and @data-bs-toggle='collapse' and contains(@href, '#ManagePublications')]
    Sleep    ${DELAY}
    Wait Until Page Contains    Manage Publications    timeout=5s
    Sleep    ${DELAY}

Click Published Research
    Click Link    xpath=//a[contains(@href, '/papers')]
    Sleep    ${DELAY}
    Wait Until Page Contains    Published research    timeout=5s
    Sleep    ${DELAY}

    # translate to cn
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[@id='navbarDropdownMenuLink']    timeout=5s
    Click Element    xpath=//a[@id='navbarDropdownMenuLink']
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/lang/zh')]
    Click Link    xpath=//a[contains(@href, '/lang/zh')]
    Sleep    ${DELAY}
    Wait Until Page Contains    中国    timeout=5s

    # Switch to Thai
    Wait Until Element Is Visible    xpath=//a[@id='navbarDropdownMenuLink' and contains(@class, 'dropdown-toggle')]
    Click Element    xpath=//a[@id='navbarDropdownMenuLink' and contains(@class, 'dropdown-toggle')]
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/lang/th')]
    Click Link    xpath=//a[contains(@href, '/lang/th')]
    Sleep    ${DELAY}
    Wait Until Page Contains    ไทย    timeout=5s
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

Click to new page
    Click Link    xpath=//a[contains(@href, '/papers/create') and contains(@class, 'btn-primary')]
    Sleep    ${DELAY}
    Wait Until Page Contains    Add    timeout=5s
    Sleep    ${DELAY}

    # translate to cn
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[@id='navbarDropdownMenuLink']    timeout=5s
    Click Element    xpath=//a[@id='navbarDropdownMenuLink']
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/lang/zh')]
    Click Link    xpath=//a[contains(@href, '/lang/zh')]
    Sleep    ${DELAY}
    Wait Until Page Contains    中国    timeout=5s

    # Switch to Thai
    Wait Until Element Is Visible    xpath=//a[@id='navbarDropdownMenuLink' and contains(@class, 'dropdown-toggle')]
    Click Element    xpath=//a[@id='navbarDropdownMenuLink' and contains(@class, 'dropdown-toggle')]
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/lang/th')]
    Click Link    xpath=//a[contains(@href, '/lang/th')]
    Sleep    ${DELAY}
    Wait Until Page Contains    ไทย    timeout=5s
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

Click Manage Publications
    Click Link    xpath=//a[@class='nav-link' and @data-bs-toggle='collapse' and contains(@href, '#ManagePublications')]
    Sleep    ${DELAY}
    Wait Until Page Contains    Manage Publications    timeout=5s
    Sleep    ${DELAY}

Click Published Research
    Click Link    xpath=//a[contains(@href, '/books')]
    Sleep    ${DELAY}
    Wait Until Page Contains    Books    timeout=5s
    Sleep    ${DELAY}

Click to new page
    Click Link    xpath=//a[contains(@href, '/books/create') and contains(@class, 'btn-primary')]
    Sleep    ${DELAY}
    Wait Until Page Contains    Add    timeout=5s
    Sleep    ${DELAY}

    # translate to cn
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[@id='navbarDropdownMenuLink']    timeout=5s
    Click Element    xpath=//a[@id='navbarDropdownMenuLink']
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/lang/zh')]
    Click Link    xpath=//a[contains(@href, '/lang/zh')]
    Sleep    ${DELAY}
    Wait Until Page Contains    中国    timeout=5s

    # Switch to Thai
    Wait Until Element Is Visible    xpath=//a[@id='navbarDropdownMenuLink' and contains(@class, 'dropdown-toggle')]
    Click Element    xpath=//a[@id='navbarDropdownMenuLink' and contains(@class, 'dropdown-toggle')]
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/lang/th')]
    Click Link    xpath=//a[contains(@href, '/lang/th')]
    Sleep    ${DELAY}
    Wait Until Page Contains    ไทย    timeout=5s
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

*** Keywords ***
Close Browser Session
    Close Browser

