# Master3

### Master3 is the Joomla 3 site template based on UIkit 3

![GitHub All Releases](https://img.shields.io/github/downloads/AlekVolsk/master3/total.svg?style=flat-square)


**WARNING! Please do not download the master repository - it does not contain the UIkit framework! <br>To install, download a created release!**

Template version 0.4.7-**beta**

UIkit version 3.0.0-rc.21

Joomla **3.7** or later

PHP **5.6** or later

Demo: http://master3.alekvolsk.info/

Screenshots admin panel: http://master3.alekvolsk.info/com-content/category-blog/screens

---

### RU:

Шаблон-болванка для Joomla 3, основанный на базе фреймворка UIkit 3.

Цель создания данного шаболна: заменить стандартный шаблон Protostar с целью обеспечения комфортного использования возможностей фреймворка UIkit. Шаблон максимально адаптирован для использования его как профессиональными веб-разработчиками, так и новичками.

Шаблон по сути представляет из себя болванку для натягивания вашего дизайна и поэтому не имеет собственных стилей и скриптов, только чистый UIkit. Для верстки с использованием препроцессоров встроенных средств компилирования стилей нет: пожалуйста, используйте профессиональные инструменты и среду разработки для профессиональной верстки.

Шаблон имеет классическую интуитивно понятную файловую структуру. В шаблоне реализовано подавляющее большинство переопределений штатных расширений Joomla. Стандартный модуль меню имеет несколько вариантов, выберите подходящий вам в модуле. Расширений, не входящих в дистрибутивный состав Joomla, нет и не будет.

Шаблон имеет массу полезных настроек для общего окружения, рендера лендинг-секций, позиций, меню. Предусмотрена поддержка отдельных слоев, привязываемых к алиасам пунктов меню: слои располагаются в папке `/lauouts`, каждый слой имеет имя файла `template.{алиас активного пункта меню (в латинице)}.php`, если к активному пункту меню не привязан ни один слой, то используется слой по умолчанию `template.default.php`. <br>
Грамотно создавайте алиасы пунктов меню! При обновлении шаблона поверх слой по умолчанию будет перезаписан! Параметры шаблона для всех слоем едины!

Сервер обновлений для шаблона не предусмотрен, т.к. создаваемая под ваш дизайн уникальная разметка может быть перезаписана в случае обновления. UIkit в случае необходимости следует обновлять вручную.

---

Positions grid:

![positions](positions.png)
