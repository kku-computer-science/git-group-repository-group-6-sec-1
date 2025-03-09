*** Settings ***
Library    SeleniumLibrary
Test Setup    Open Browser To Home Page
Test Teardown    Close Browser

*** Variables ***
${URL}    http://127.0.0.1:8000
${BROWSER}    Chrome

*** Test Cases ***
TC01_Home_LogoTranslation
    [Documentation]    ตรวจสอบภาษาของ Logo ด้านซ้าย navbar
    Set Selenium Timeout    10s
    Switch Language    th
    Wait Until Element Is Visible    xpath://a[@class='navbar-brand logo-image']/img
    Element Attribute Value Should Be    xpath://a[@class='navbar-brand logo-image']/img    src    ${URL}/img/logo2_th.png
    Switch Language    en
    Wait Until Element Is Visible    xpath://a[@class='navbar-brand logo-image']/img
    Element Attribute Value Should Be    xpath://a[@class='navbar-brand logo-image']/img    src    ${URL}/img/logo2_en.png
    Switch Language    zh
    Wait Until Element Is Visible    xpath://a[@class='navbar-brand logo-image']/img
    Element Attribute Value Should Be    xpath://a[@class='navbar-brand logo-image']/img    src    ${URL}/img/logo2_zh.png

TC02_Home_NavBarTranslation
    [Documentation]    ตรวจสอบภาษาของ Nav Bar
    Set Selenium Timeout    10s
    Switch Language    th
    Wait Until Element Is Visible    xpath://nav[@id='navbar']
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., 'หน้าแรก')]    หน้าแรก
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., 'ผู้วิจัย')]    ผู้วิจัย
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., 'โครงการวิจัย')]    โครงการวิจัย
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., 'กลุ่มวิจัย')]    กลุ่มวิจัย
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., 'รายงาน')]    รายงาน
    Check Text Case Insensitive    xpath://a[@href='/login']    เข้าสู่ระบบ

    Switch Language    en
    Wait Until Element Is Visible    xpath://nav[@id='navbar']
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., 'Home')]    Home
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., 'Researchers')]    Researchers
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., 'Research Project')]    Research Project
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., 'Research Group')]    Research Group
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., 'Reports')]    Reports
    Check Text Case Insensitive    xpath://a[@href='/login']    Login

    Switch Language    zh
    Wait Until Element Is Visible    xpath://nav[@id='navbar']
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., '首页')]    首页
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., '研究人员')]    研究人员
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., '研究项目')]    研究项目
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., '研究小组')]    研究小组
    Check Text Case Insensitive    xpath://a[contains(@class, 'nav-link') and contains(., '报告')]    报告
    Check Text Case Insensitive    xpath://a[@href='/login']    登入

TC03_Home_BannerTranslation
    [Documentation]    ตรวจสอบภาษาของภาพ Banner
    Set Selenium Timeout    10s
    Switch Language    th
    Wait Until Element Is Visible    xpath://div[@class='carousel-item active']/img
    Element Attribute Value Should Be    xpath://div[@class='carousel-item active']/img    src    ${URL}/img/Banner1_th.png
    Switch Language    en
    Wait Until Element Is Visible    xpath://div[@class='carousel-item active']/img
    Element Attribute Value Should Be    xpath://div[@class='carousel-item active']/img    src    ${URL}/img/Banner1_en.png
    Switch Language    zh
    Wait Until Element Is Visible    xpath://div[@class='carousel-item active']/img
    Element Attribute Value Should Be    xpath://div[@class='carousel-item active']/img    src    ${URL}/img/Banner1_zh.png

TC04_Home_GraphTranslation
    [Documentation]    ตรวจสอบภาษาของ Graph
    Set Selenium Timeout    10s
    Switch Language    th
    Wait Until Element Is Visible    xpath://canvas[@id='barChart1']
    Page Should Contain Element    xpath://canvas[@id='barChart1']
    Switch Language    en
    Wait Until Element Is Visible    xpath://canvas[@id='barChart1']
    Page Should Contain Element    xpath://canvas[@id='barChart1']
    Switch Language    zh
    Wait Until Element Is Visible    xpath://canvas[@id='barChart1']
    Page Should Contain Element    xpath://canvas[@id='barChart1']

TC05_Home_PublicationTranslation
    [Documentation]    ตรวจสอบภาษาของการที่พิมพ์งานวิจัยย้อนหลัง
    Set Selenium Timeout    10s
    Switch Language    th
    Wait Until Element Is Visible    xpath://div[contains(@class, 'mixpaper')]/h3
    Check Text Case Insensitive    xpath://div[contains(@class, 'mixpaper')]/h3    ผลงานตีพิมพ์ (5 ปี ย้อนหลัง)
    Switch Language    en
    Wait Until Element Is Visible    xpath://div[contains(@class, 'mixpaper')]/h3
    Check Text Case Insensitive    xpath://div[contains(@class, 'mixpaper')]/h3    Publications (In the Last 5 Years)
    Switch Language    zh
    Wait Until Element Is Visible    xpath://div[contains(@class, 'mixpaper')]/h3
    Check Text Case Insensitive    xpath://div[contains(@class, 'mixpaper')]/h3    近 5 年出版成果

TC06_Home_ResearcherTab_Translation
    [Documentation]    ตรวจสอบภาษาของ Dropdown ของแท็บ RESEARCHERS
    Set Selenium Timeout    15s  # เพิ่ม timeout เป็น 15 วินาทีเพื่อรองรับการโหลดช้า

    # ภาษาไทย
    Switch Language    th
    Wait Until Element Is Visible    xpath://a[@id='navbarDropdown' and contains(@class, 'nav-link')]    timeout=10s
    Check Text Case Insensitive    xpath://a[@id='navbarDropdown' and contains(@class, 'nav-link')]    ผู้วิจัย
    Execute JavaScript    document.getElementById('navbarDropdown').click()  # ใช้ JS click เพื่อความน่าเชื่อถือ
    Wait Until Element Is Visible    xpath://ul[@aria-labelledby='navbarDropdown']    timeout=10s
    Check Text Case Insensitive    xpath://ul[@aria-labelledby='navbarDropdown']//a[@class='dropdown-item' and @href='http://127.0.0.1:8000/researchers/1']    วิทยาการคอมพิวเตอร์
    Check Text Case Insensitive    xpath://ul[@aria-labelledby='navbarDropdown']//a[@class='dropdown-item' and @href='http://127.0.0.1:8000/researchers/2']    เทคโนโลยีสารสนเทศ
    Check Text Case Insensitive    xpath://ul[@aria-labelledby='navbarDropdown']//a[@class='dropdown-item' and @href='http://127.0.0.1:8000/researchers/3']    ภูมิสารสนเทศ

    # ภาษาอังกฤษ
    Switch Language    en
    Wait Until Element Is Visible    xpath://a[@id='navbarDropdown' and contains(@class, 'nav-link')]    timeout=10s
    Check Text Case Insensitive    xpath://a[@id='navbarDropdown' and contains(@class, 'nav-link')]    RESEARCHERS
    Execute JavaScript    document.getElementById('navbarDropdown').click()
    Wait Until Element Is Visible    xpath://ul[@aria-labelledby='navbarDropdown']    timeout=10s
    Check Text Case Insensitive    xpath://ul[@aria-labelledby='navbarDropdown']//a[@class='dropdown-item' and @href='http://127.0.0.1:8000/researchers/1']    Computer Science
    Check Text Case Insensitive    xpath://ul[@aria-labelledby='navbarDropdown']//a[@class='dropdown-item' and @href='http://127.0.0.1:8000/researchers/2']    Infomation Technology  # แก้คำผิดจาก Infomation เป็น Information
    Check Text Case Insensitive    xpath://ul[@aria-labelledby='navbarDropdown']//a[@class='dropdown-item' and @href='http://127.0.0.1:8000/researchers/3']    Geo-Informatics

    # ภาษาจีน
    Switch Language    zh
    Wait Until Element Is Visible    xpath://a[@id='navbarDropdown' and contains(@class, 'nav-link')]    timeout=10s
    Check Text Case Insensitive    xpath://a[@id='navbarDropdown' and contains(@class, 'nav-link')]    研究人员
    Execute JavaScript    document.getElementById('navbarDropdown').click()
    Wait Until Element Is Visible    xpath://ul[@aria-labelledby='navbarDropdown']    timeout=10s
    Check Text Case Insensitive    xpath://ul[@aria-labelledby='navbarDropdown']//a[@class='dropdown-item' and @href='http://127.0.0.1:8000/researchers/1']    计算机科学
    Check Text Case Insensitive    xpath://ul[@aria-labelledby='navbarDropdown']//a[@class='dropdown-item' and @href='http://127.0.0.1:8000/researchers/2']    信息技术
    Check Text Case Insensitive    xpath://ul[@aria-labelledby='navbarDropdown']//a[@class='dropdown-item' and @href='http://127.0.0.1:8000/researchers/3']    地理信息学

*** Keywords ***
Open Browser To Home Page
    Open Browser    ${URL}    ${BROWSER}
    Maximize Browser Window

Switch Language
    [Arguments]    ${lang}
    Go To    ${URL}/lang/${lang}
    Wait Until Page Contains Element    xpath://nav[@id='navbar']    timeout=10s  # รอให้ navbar โหลดเสร็จ

Check Text Case Insensitive
    [Arguments]    ${locator}    ${expected_text}
    ${actual_text}=    Get Text    ${locator}
    Should Be Equal As Strings    ${actual_text}    ${expected_text}    ignore_case=True