*** Settings ***
Library    SeleniumLibrary

*** Variables ***
${URL}      http://127.0.0.1:8000/researchers/1
${BROWSER}  Chrome

*** Test Cases ***
Open Login Page
    Open Browser    ${URL}    ${BROWSER}
    Maximize Browser Window
    Sleep    5
    Close Browser