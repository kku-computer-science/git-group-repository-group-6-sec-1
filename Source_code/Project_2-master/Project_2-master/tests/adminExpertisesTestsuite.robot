*** Settings ***
Documentation   Test suite for Admin Profile Page
Library         SeleniumLibrary

*** Variables ***

${MAIN_PAGE_URL}    http://127.0.0.1:8000/
${LOGIN_URL}        http://127.0.0.1:8000/login
${EXPERTS_URL}      http://127.0.0.1:8000/experts 
${USERNAME}         admin@gmail.com
${PASSWORD}         12345678
${EXPERT_NAME_EN}   Augmented Reality
${EXPERT_NAME_TH}   เทคโนโลยีความจริงเสริม
${EXPERT_NAME_ZH}   增强现实
${UPDATED_EXPERT_NAME_EN}   Virtual Reality
${BROWSER}          Edge
${DELAY}           1.5s
${TIMEOUT}         2s

*** Test Cases ***
Start At Main Page And Go To Login
    Open Browser    ${MAIN_PAGE_URL}    ${BROWSER}
    Maximize Browser Window
    Click Link    xpath=//a[contains(text(), 'Login')]
    Sleep    ${DELAY}
    Wait Until Page Contains    Login    timeout=2s
    Switch Window    NEW  # Switch to the newly opened tab
    Sleep    ${DELAY}

Admin User Can Login Successfully
    Input Text      name=username    ${USERNAME}
    Input Text      name=password    ${PASSWORD}
    Click Button    xpath=//button[@type='submit' and contains(text(), 'Login')]
    Sleep    ${DELAY}
    Wait Until Page Contains    Dashboard    timeout=2s
    Sleep    ${DELAY}

Navigate To Experts Page
    Wait Until Page Contains    Dashboard    timeout=2s
    Wait Until Element Is Visible    xpath=//a[contains(@class, 'nav-link') and @href='http://127.0.0.1:8000/experts']    timeout=${TIMEOUT}
    Scroll Element Into View    xpath=//a[contains(@class, 'nav-link') and @href='http://127.0.0.1:8000/experts']
    Click Element    xpath=//a[contains(@class, 'nav-link') and @href='http://127.0.0.1:8000/experts']
    Wait Until Page Contains    experts    timeout=3s
    Location Should Contain    ${EXPERTS_URL}

Add New Expert
    Wait Until Element Is Visible    xpath=//a[contains(@href, 'experts/create')]    timeout=${TIMEOUT}
    Click Element    xpath=//a[contains(@href, 'experts/create')]
    Wait Until Page Contains    Add New Expert    timeout=${TIMEOUT}
    Select From List By Value    name=user_id    1
    Input Text    xpath=//input[@name='expert_name[]']    ${EXPERT_NAME_EN}
    Input Text    xpath=//input[@name='expert_name_th[]']    ${EXPERT_NAME_TH}
    Input Text    xpath=//input[@name='expert_name_zh[]']    ${EXPERT_NAME_ZH}
    Wait Until Element Is Enabled    xpath=//button[@id='btn-save']    timeout=${TIMEOUT}
    Click Button    xpath=//button[@id='btn-save']

Search For Added Expert
    Wait Until Element Is Visible    xpath=//div[@id='example1_filter']//input[@type='search']    timeout=${TIMEOUT}  # Refined to target specific DataTables filter
    Input Text    xpath=//div[@id='example1_filter']//input[@type='search']    ${EXPERT_NAME_EN}
    Sleep    ${DELAY}  # Allow DataTables to filter results
    Wait Until Page Contains Element    xpath=//td[contains(text(), '${EXPERT_NAME_EN}')]    timeout=${TIMEOUT}
    Element Should Be Visible    xpath=//td[contains(text(), '${EXPERT_NAME_EN}')]

Edit Added Expert
    Wait Until Element Is Visible    xpath=//td[contains(text(), '${EXPERT_NAME_EN}')]/following-sibling::td//a[contains(@class, 'edit-expertise')]    timeout=${TIMEOUT}
    Click Element    xpath=//td[contains(text(), '${EXPERT_NAME_EN}')]/following-sibling::td//a[contains(@class, 'edit-expertise')]
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//div[@id='crud-modal' and contains(@class, 'show')]    timeout=${TIMEOUT}  # Modal is visible
    Input Text    xpath=//input[@id='expert_name']    ${UPDATED_EXPERT_NAME_EN}
    Sleep    ${DELAY}
    Clear Element Text    xpath=//input[@id='expert_name_th']
    Input Text    xpath=//input[@id='expert_name_th']    ${EXPERT_NAME_TH}  # Keep Thai name same
    Clear Element Text    xpath=//input[@id='expert_name_zh']
    Input Text    xpath=//input[@id='expert_name_zh']    ${EXPERT_NAME_ZH}  # Keep Chinese name same
    Wait Until Element Is Enabled    xpath=//button[@id='btn-save']    timeout=${TIMEOUT}
    Click Button    xpath=//button[@id='btn-save']
    Wait Until Page Contains    experts    timeout=${TIMEOUT}

Delete Edited Expert
    Wait Until Element Is Visible    xpath=//div[@id='example1_filter']//input[@type='search']    timeout=${TIMEOUT}
    Input Text    xpath=//div[@id='example1_filter']//input[@type='search']    ${UPDATED_EXPERT_NAME_EN}  # Search again for updated name
    Sleep    ${DELAY}
    Wait Until Element Is Visible    xpath=//td[contains(text(), '${UPDATED_EXPERT_NAME_EN}')]/following-sibling::td//button[contains(@class, 'show_confirm')]    timeout=${TIMEOUT}
    Click Button    xpath=//td[contains(text(), '${UPDATED_EXPERT_NAME_EN}')]/following-sibling::td//button[contains(@class, 'show_confirm')]
    Wait Until Element Is Visible    xpath=//div[contains(@class, 'swal-modal')]    timeout=${TIMEOUT}  # SweetAlert confirmation
    Click Button    xpath=//button[contains(@class, 'swal-button--confirm')]  # Confirm deletion
    Wait Until Page Does Not Contain Element    xpath=//td[contains(text(), '${UPDATED_EXPERT_NAME_EN}')]    timeout=${TIMEOUT}

*** Keywords ***
Close Browser Session
    Close Browser

