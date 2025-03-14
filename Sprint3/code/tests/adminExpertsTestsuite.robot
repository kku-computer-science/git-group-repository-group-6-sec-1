*** Settings ***
Documentation   To test the admin expertise management page functionality
Library         SeleniumLibrary

*** Variables ***
${MAIN_PAGE_URL}    http://127.0.0.1:8000/
${LOGIN_URL}        http://127.0.0.1:8000/login
${EXPERTS_URL}      http://127.0.0.1:8000/experts
${USERNAME}         admin@gmail.com
${PASSWORD}         12345678
${BROWSER}          Edge
${DELAY}            0.5s

*** Keywords ***
Open Main Page And Go To Login
    Open Browser    ${MAIN_PAGE_URL}    ${BROWSER}
    Maximize Browser Window
    Click Link    xpath=//a[contains(text(), 'Login')]
    Wait Until Page Contains Element    xpath=//a[contains(text(), 'Login')]    timeout=5s
    Wait Until Element Is Visible    name=username    timeout=5s

Login As Admin
    Input Text    id=email    ${USERNAME}
    Input Password    id=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit']


Navigate To Experts
    Wait Until Element Is Visible    xpath=//a[@class='nav-link ' and contains(@href, '/experts')]
    Click Link    xpath=//a[@class='nav-link ' and contains(@href, '/experts')]
    Wait Until Page Contains    Experts    timeout=5s

*** Test Cases ***
Test Admin Can Access Main Page And Login
    [Documentation]    Verify admin can access main page and login successfully
    Open Main Page And Go To Login
    Login As Admin
    [Teardown]    Close Browser

Test Navigation To Experts Page
    [Documentation]    Verify admin can navigate to experts page after login
    Open Main Page And Go To Login
    Login As Admin
    Navigate To Experts
    Page Should Contain Element    xpath=//table[@id='example1']
    [Teardown]    Close Browser

Test Add Expert Button Visibility
    [Documentation]    Verify add expert button is visible for admin
    Open Main Page And Go To Login
    Login As Admin
    Navigate To Experts
    Wait Until Element Is Visible    xpath=//a[contains(@href, 'experts.create') and contains(@class, 'btn-primary')]
    [Teardown]    Close Browser

Test Expert Table Structure
    [Documentation]    Verify experts table contains correct columns
    Open Main Page And Go To Login
    Login As Admin
    Navigate To Experts
    Page Should Contain Element    xpath=//th[contains(text(), 'ID')]
    Page Should Contain Element    xpath=//th[contains(text(), 'Teacher Name')]
    Page Should Contain Element    xpath=//th[contains(text(), 'Name')]
    Page Should Contain Element    xpath=//th[contains(text(), 'Action')]
    [Teardown]    Close Browser

Test Edit Expert Button Functionality
    [Documentation]    Verify edit button opens the modal
    Open Main Page And Go To Login
    Login As Admin
    Navigate To Experts
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'edit-expertise')]
    Click Element    xpath=//a[contains(@class, 'edit-expertise')][1]
    Wait Until Element Is Visible    xpath=//div[@id='crud-modal' and contains(@class, 'show')]
    Page Should Contain Element    xpath=//input[@id='expert_name']
    [Teardown]    Close Browser

Test Delete Confirmation Appears
    [Documentation]    Verify delete button shows confirmation
    Open Main Page And Go To Login
    Login As Admin
    Navigate To Experts
    Wait Until Element Is Visible    xpath=//button[contains(@class, 'show_confirm')]
    Click Element    xpath=//button[contains(@class, 'show_confirm')][1]
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-modal')]
    [Teardown]    Close Browser