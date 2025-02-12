<?php

use Bitrix\Main\Application;

class MUfilesNumeration {
    public static function OnAdminTabControlBeginHandler() {
        // применяем только к редактированию элемента
        $request = Application::getInstance()->getContext()->getRequest();
        $page = $request->getRequestedPage();
        if ($page != '/bitrix/admin/iblock_element_edit.php') return;
        ?>

        <style>
            .adm-fileinput-item-image .mu_files_numeration_badge {
                position: absolute;
                top: 0;
                left: 0;
                padding: 5px;
                z-index: 1;
                font-size: 1rem;
                border-radius: inherit;
                box-sizing: border-box;
                background: #191d2a;
                color: #fff;
                line-height: 1rem;
            }
        </style>
        <script>
            (() => {
                function muFilesNumeration() {
                    // ищем все свойства типа файл
                    let all_blocks = document.querySelectorAll("[id^='bx_file_prop'].adm-fileinput-area-container");
                    if (all_blocks.length == 0) return

                    all_blocks.forEach((file_block) => {
                        // функция создания ярлыка с номером
                        function filesNumeration() {
                            file_block
                                .querySelectorAll(".adm-fileinput-item-image")
                                .forEach((item, index) => {
                                    // удаляет старый ярлык, если есть
                                    if (item.querySelector(".mu_files_numeration_badge")) {
                                        item.querySelector(".mu_files_numeration_badge").remove();
                                    }

                                    // создаём новый ярлык
                                    let number = document.createElement("div");
                                    number.classList.add("mu_files_numeration_badge");
                                    number.innerHTML = index;
                                    item.querySelector(".adm-fileinput-item").prepend(number);
                                })
                        }

                        // запускаем нумерацию
                        filesNumeration();

                        // наблюдатель за изменениями в списке файлов
                        var observer = new MutationObserver(function (mutations) {
                            mutations.forEach(function (mutation) {
                                if (mutation.addedNodes.length || mutation.removedNodes.length) {
                                    filesNumeration();
                                }
                            });
                        });

                        // запускаем обсервер
                        if (file_block) {
                            observer.observe(file_block, {childList: true});
                        }
                    })
                }

                // запускаем скрипт на загрузку страницы
                window.addEventListener('load', (event) => {
                    muFilesNumeration();
                })

                // запускаем скрипт по интервалу для эрмитажа
                let muFilesNumerationInterval = setInterval(() => {
                    if (document.querySelector(".mu_files_numeration_badge")) {
                        clearInterval(muFilesNumerationInterval)
                    }
                    muFilesNumeration();
                }, 250);
            })()
        </script>
        <?
    }
}