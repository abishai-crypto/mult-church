# Mfumo wa Kisasa wa Usimamizi wa Kanisa (Multi-Tenant Church Management System)
**EVANGELIST ASSEMBLIES OF GOD TANZANIA (EAGT)**

Mfumo thabiti, wa kisasa, na salama wa wavuti na simu (PWA) uliotengenezwa mahususi kurahisisha uendeshaji, utunzaji wa kumbukumbu, mawasiliano ya SMS, na uwajibikaji wa kifedha katika kanisa la Pentekoste.

---

## 🌟 Sifa Kuu za Mfumo (Core Features)

### 1. Hazina na Udhibiti Pacha wa Fedha (Dual-Control Financial System)
* **Sheria ya Zaka:** Zaka zikithibitishwa na Wazee wa Kanisa hazihifadhiwi kwenye hazina ya kawaida; zinapelekwa moja kwa moja kwa Mchungaji Kiongozi. Mhazini haruhusiwi kuona Zaka kwenye leja kuu.
* **Uthibitisho Pacha (Dual-Control):** Mtu aliyeingiza muamala haruhusiwi kuuthibitisha yeye mwenyewe; Mzee wa Kanisa au Mchungaji lazima athibitishe.
* **Kutoa Ripoti (Export):** Uwezo wa kupakua taarifa rasmi ya mapato na matumizi katika **PDF (Print-Ready)** yenye nafasi za saini za viongozi, na **Excel (CSV)**.

### 2. Lango la Sadaka na Zaka Mtandaoni (Online Giving)
* Waumini na wageni wanaweza kutoa Zaka, Sadaka ya Kawaida, Shukrani, na Michango ya Ujenzi moja kwa moja kupitia tovuti ya kanisa.
* Inasaidia mitandao yote ya simu Tanzania: **M-Pesa, Tigo Pesa, Airtel Money, Halopesa** pamoja na benki za **CRDB na NMB**.
* Inatoa nambari ya uthibitisho (`TXN-ONL-XXXXXX`) na kutuma SMS ya shukrani kiotomatiki kwa mtoaji.

### 3. Kituo cha Mawasiliano: SMS na WhatsApp (Automated SMS & WhatsApp Hub)
* **Kitufe cha Moja kwa Moja cha WhatsApp (Floating WhatsApp Widget):** Tovuti ina kitufe cha kisasa cha WhatsApp kinachomwezesha mgeni au mshirika kuchagua na kuwasiliana papo hapo na:
  * Mchungaji Kiongozi (Ushauri na Maombi)
  * Ofisi ya Kanisa / Katibu (Ratiba na Vyeti)
  * Vijana CGM (Kambi na Kwaya)
* **Risiti za Zaka kwa WhatsApp (WhatsApp Receipts):** Viongozi wa hazina wanaweza kubofya kitufe cha *"WhatsApp Risiti"* kwenye orodha ya miamala iliyothibitishwa, ikifungua ujumbe uliopangika vizuri wenye aya ya Malaki 3:10, jina la mshirika, kiasi, na namba ya kumbukumbu.
* **Mawasiliano ya Muumini (Click-to-Chat):** Kila mshirika kwenye Daftari la Waumini ana kitufe cha kijani cha WhatsApp kwa ajili ya kufungua mazungumzo naye bila kulazimika kusave namba kwanza kwenye simu.
* **SMS za Kiotomatiki na za Wingi (Bulk SMS):** Kutuma SMS kwa waumini wote au kwa idara maalum (k.m. Vijana CGM, Wanawake WWK, Kwaya, Mashemasi) kupitia **Beem Africa**, **NextSMS**, au **Twilio**.

### 4. Daftari Kuu la Waumini na Idara
* Usajili wa washirika wenye nambari maalum za utambulisho (k.m. `EAGT-MBR-0001`).
* Taarifa za ubatizo wa maji mengi, tarehe za kuzaliwa, na anwani za makazi.
* Usimamizi wa idara:
  * **CGM (Christ Gospel Messengers)** – Idara ya Vijana
  * **WWK** – Wanawake wa Kristo
  * **CWI** – Watoto na Sunday School
  * **Ujenzi na Maendeleo** – Kamati ya Hekalu Jipya
  * **Kwaya Kuu ya Uinjilisti**
  * **Mashemasi na Itifaki**

### 5. Mahudhurio na Ufuatiliaji wa Wageni (Attendance & Converts)
* Kurekodi idadi ya wanaume, wanawake, na watoto kila ibada.
* Kufuatilia wageni wa mara ya kwanza (**First Timers**) na waliookoka (**Altar Call**).
* Chati za mwenendo wa mahudhurio na ripoti ya takwimu ya kupakua/kuchapisha.

### 6. Huduma ya Kichungaji na Maombi ya Siri (Confidential Pastoral Care)
* Rekodi za ziara za kichungaji (Pastoral visits) na wagonjwa hospitalini/majumbani.
* Maombi ya siri (**Confidential Prayer Requests**) yanayolindwa na kuonekana na Mchungaji na Wazee wa Kanisa pekee.

### 7. PWA (Progressive Web App)
* Tovuti inafanya kazi kama App ya simu. Muumini au kiongozi anaweza kubofya *"Weka kwenye Simu / Add to Home Screen"* kwenye Android au iPhone na kuitumia moja kwa moja.

---

## 🔑 Akaunti za Majaribio (Demo Accounts)

Nenosiri la akaunti zote ni: **`password`**

| Wadhifa / Role | Barua Pepe (Email) | Idhini Kuu |
| :--- | :--- | :--- |
| **Super Admin** | `superadmin@multichurch.org` | Usimamizi mkuu wa mfumo na makanisa yote |
| **Mchungaji Kiongozi** | `pastor@eagt.org` | Kuona Zaka, maombi ya siri, kuidhinisha matumizi |
| **Admin wa Kanisa** | `admin@eagt.org` | Mipangilio yote ya kanisa na watumiaji |
| **Mzee wa Kanisa** | `elder@eagt.org` | Kuthibitisha Zaka na mapato, maombi ya siri |
| **Mtunza Hazina** | `treasurer@eagt.org` | Kuingiza miamala, vocha za matumizi (Hana Zaka) |
| **Katibu wa Kanisa** | `secretary@eagt.org` | Daftari la waumini, mahudhurio, SMS |
| **Kiongozi wa Vijana** | `youthleader@eagt.org` | Uongozi wa idara ya CGM |
| **Muumini** | `member@eagt.org` | Kuona matangazo, ratiba, kutoa sadaka mtandaoni |

---

## 💻 Mwongozo wa Kusanidi (Local Installation)

1. **Pakua au clone mradi:**
   ```bash
   git clone https://github.com/JINA-LAKO/mult-church.git
   cd mult-church
   ```

2. **Sakinisha vifurushi vya PHP:**
   ```bash
   composer install
   ```

3. **Weka faili la mazingira (.env):**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Sanidi Database kwenye `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306  # au 3307 kulingana na MySQL yako
   DB_DATABASE=mult_church
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Endesha Migrations na Seeders:**
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   ```

6. **Washa Seva ya Majaribio:**
   ```bash
   php artisan serve
   ```
   Fungua browser yako kwenye [http://127.0.0.1:8000](http://127.0.0.1:8000).

---

## 🚀 Mwongozo wa Kupandisha Cloud (Deployment Guide)

### Mambo Muhimu Kwenye Seva ya Uzalishaji (Production):
1. **Weka `.env` sahihi:**
   * `APP_ENV=production`
   * `APP_DEBUG=false`
   * `APP_URL=https://tovuti-ya-kanisa.org`
2. **Kumbukumbu na Utendaji (Optimization Cache):**
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   php artisan storage:link
   ```
3. **Kusanidi Cron Job (Laravel Scheduler):**
   ```bash
   * * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
   ```
4. **Kutumia Docker:**
   Mradi huu una `Dockerfile` iliyosanidiwa tayari kwa ajili ya kurusha kwenye **DigitalOcean App Platform, Railway, Render, au VPS**.

---

## 📄 Leseni
Mfumo huu umehifadhiwa chini ya Leseni ya **MIT**.
