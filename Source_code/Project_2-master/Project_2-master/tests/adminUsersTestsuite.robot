*** Settings ***
Documentation   Test suite for Admin Profile Page
Library         SeleniumLibrary

*** Variables ***
${MAIN_PAGE_URL}    http://127.0.0.1:8000/
${LOGIN_URL}        http://127.0.0.1:8000/login 
${USERNAME}         admin@gmail.com
${PASSWORD}         12345678
${BROWSER}          Edge
${DELAY}           .25s

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

Navigate To User Page
    Click Link    xpath=//a[@class='nav-link' and contains(@href, '/users')]
    Sleep    ${DELAY}
    Wait Until Page Contains    Users    timeout=5s
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

Click to Add new page
    Click Link    xpath=//a[contains(@href, '/users/create') and contains(@class, 'btn-primary')]
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

#Navigate To User Page again
    Click Link    xpath=//a[@class='nav-link' and contains(@href, '/users')]

Click to Import New User
    Click Link    xpath=//a[contains(@href, '/importfiles') and contains(@class, 'btn-primary')]
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

#Navigate To User Page again
    Click Link    xpath=//a[@class='nav-link' and contains(@href, '/users')]

Click to View Button
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/users/') and contains(@class, 'btn-outline-primary')]    timeout=5s
    Scroll Element Into View        xpath=//a[contains(@href, '/users/') and contains(@class, 'btn-outline-primary')]
    Sleep    ${DELAY}
    Wait Until Element Is Not Visible    xpath=//div[contains(@class, 'overlay')]    timeout=5s
    Click Element    xpath=//a[contains(@href, '/users/') and contains(@class, 'btn-outline-primary')]
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

Click Back Button
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/users') and contains(@class, 'btn-primary')]    timeout=5s
    Scroll Element Into View        xpath=//a[contains(@href, '/users') and contains(@class, 'btn-primary')]
    Click Link    xpath=//a[contains(@href, '/users') and contains(@class, 'btn-primary')]
    Sleep    ${DELAY}
    Wait Until Page Contains    Users    timeout=5s
    Sleep    ${DELAY}

Click Edit Button
    Wait Until Element Is Visible    xpath=//a[contains(@href, '/users/') and contains(@href, '/edit') and contains(@class, 'btn-outline-success')]    timeout=5s
    Scroll Element Into View        xpath=//a[contains(@href, '/users/') and contains(@href, '/edit') and contains(@class, 'btn-outline-success')]
    Click Link    xpath=//a[contains(@href, '/users/') and contains(@href, '/edit') and contains(@class, 'btn-outline-success')]
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

#Navigate To User Page again
    Click Link    xpath=//a[@class='nav-link' and contains(@href, '/users')]



*** Keywords ***
Close Browser Session
    Close Browser