<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Document</title>
    <style>
        body {
            font-family: "meiryo";
            padding: 0;
        }

        b {
            font-size: 16px;
            line-height: 25px;
            margin: 20px 0 5px 0;
            font-weight: 700;
        }

        .content__label {
            font-size: 16px;
            line-height: 25px;
            color: #2A3242;
            margin-bottom: 0;
            margin-top: 14px;
            font-weight: 700;
        }
        .content__nda__text {
            font-size: 14px;
            line-height: 20px;
            color: #2A3242;
            margin-bottom: 0;
        }
        .ol-group, .ol-children {
            margin-left: 20px;
        }
        .ol-group {
            margin-left: 0;
            margin-bottom: 0;
            padding-left: 22px;
        }
        ol li {
            list-style: number;
            font-size: 14px;
            line-height: 20px;
            color: #2A3242;
        }
        ol ol.ol-children li {
            color: blue;
            counter-increment: section1;
        }
        .ol-children li::marker {
            color: yellow;
            content: "(" counter(section1) ") ";
        }

        .ul-children {
            margin-left: 0;
            padding-left: 25px;
        }
        .ul-children li {
            list-style-type: none;
            position: relative;
        }
        .ul-children li::before {
            position: absolute;
            margin-right: 20px;
            top: 0;
            left: -35px;
            counter-increment: section;
            content: " （" counter(section) "）";
  
        }
        .ul-children.ul-children2 li::before {
            counter-increment: section2;
            content: " （" counter(section2) "）";
        }
        .ul-children.ul-children3 li::before {
            counter-increment: section3;
            content: " （" counter(section3) "）";
        }
    </style>
</head>
<body>
    <div class="wrap-pdf" style="word-wrap: break-word;">
        <div class="content__nda">
            <p class="content__nda__text content__nda__text--mb-35">秘密保持契約（以下、「本契約」という）は、双方に知り得た秘密情報を厳密に管理し、書面による承諾なく、本契約の内容および秘密情報を他者に漏らさないことを約束する契約です。オンライン占いサービスを提供される出品者様は、購入者様が安心して当サービスをご利用いただくため、秘密保持契約の締結をお願い致します。</p>
            <p class="content__nda__text">「甲」と「乙」の両当事者が開示する秘密情報の取扱いについて、検討するにあたり（以下「本取引」という。）、甲又は乙が相手方に開示する秘密情報の取扱いについて、以下のとおりの秘密保持契約（以下「本契約」という。）を締結する。</p>
            <b for="" class="f-w6">第1条（秘密情報）</b>
            <div class="nda-wrap">
                <ol class="ol-group">
                    <li>本契約における「秘密情報」とは、以下の情報を含みます。</li>
                    <ol class="ul-children">
                        <li>
                            乙のサービスを利用して仕事を依頼する購入者に関する情報（氏名、生年月日、鑑定内容・相談内容を含みが、これに限 らないものとする）
                        </li>
                        <li>購入者が発注する仕事に関する情報</li>
                        <li>甲が、乙のサービスを利用して受注した仕事に関して、購入者又は乙から受領した情報</li>
                    </ol>
                    <li>ただし、開示を受けた当事者が書面によってその根拠を立証できる場合に限り、以下の情報は秘密情報の対象外とするものとする。</li>
                    <ol class="ul-children ul-children2">
                        <li>開示を受けたときに既に保有していた情報</li>
                        <li>開示を受けた後、秘密保持義務を負うことなく第三者から正当に入手した情報</li>
                        <li>開示を受けた後、相手方から開示を受けた情報に関係なく独自に取得し、又は創出した情報</li>
                        <li>開示を受けたときに既に公知であった情報</li>
                        <li>開示を受けた後、自己の責めに帰し得ない事由により公知となった情報</li>
                    </ol>
                </ol>
            </div>
            <b for="" class="f-w6">第2条（秘密保持義務）</b>
            <div class="nda-wrap">
                <ol class="ol-group">
                    <li>受領当事者は、開示当事者から開示を受けた秘密情報について厳に秘密を保持し、開示当事者の書面による承諾なく、本契約の内容および秘密情報を開示又は漏洩してはならない。</li>
                    <li>前項にかかわらず、次に揚げる場合については、受領当事者は秘密情報を開示することができる。 ただし、受領当事者は、開示を行う前に開示当事者に対して、当該開示の時期、方法および手段について協議するために最善の努力をなすものとする。</li>
                    <ol class="ul-children ul-children3">
                        <li>法令又は官公署の命令により開示することが要求される場合</li>
                        <li>官公署からの要請等、受領当事者による開示に正当な理由があるものと受領当事者が合理的に判断した場合</li>
                    </ol>
                </ol>
            </div>
            <b for="" class="f-w6">第3条（管理）</b>
            <div class="nda-wrap">
                <ol class="ol-group">
                    <li>甲および乙は、本契約の趣旨に則り、相手方から開示された秘密情報等を、善良なる管理者としての注意義務をもって厳重に保管、管理する。</li>
                    <li>受領当事者は、開示当事者から開示された秘密情報について、厳重に管理の上、関係者のみの取扱いとし、第三者に貸与、譲渡等してはならない。また、開示当事者からの返還もしくは廃棄の要請がある場合、それに従う。</li>
                    <li>受領当事者は、開示当事者から開示された秘密情報を本件業務の目的にのみ使用するものとし、事前に開示当事者の書面による承諾を得ることなく他のいかなる目的にも使用しない。</li>
                </ol>
            </div>
            <b for="" class="f-w6">第4条（開示当事者による監督）</b>
            <div class="nda-wrap">
                <div class="content__nda__text">開示当事者は、受領当事者に対し、必要に応じて、秘密情報の管理状況に関する報告等を求めることができるとともに、本契約の履行確保のために、受領当事者に対し管理状況の改善を要請することができる。
                </div>
            </div>
            <b for="" class="f-w6">第5条（秘密情報の返還および廃棄）</b>
            <div class="nda-wrap">
                <ol class="ol-group">
                    <li>受領当事者は、本件業務の履行が終了する場合、及び開示当事者から要請があった場合は、直ちに開示当事者の指示に従い、開示当事者から提供を受けた秘密情報ならびにその複製物および複写物の全てを開示当事者に返還又は廃棄しなければならない。</li>
                    <li>前項にかかわらず、法令で保管義務等の定めのある文書等については当該法令の定めに従う。</li>
                </ol>
            </div>
            <b for="" class="f-w6">第6条（損害賠償等）</b>
            <div class="nda-wrap">
                <ol class="ol-group">
                    <li>受領当事者は､秘密情報の漏洩等の事故が生じた場合には、速やかに開示当事者に対しこれを報告し、 開示当事者の指示を受けるものとする。</li>
                    <li>受領当事者が相手方の秘密情報等を開示するなど本契約に定める事項に違反したことにより、開示当事者が損害を被った場合、受領当事者は開示当事者が被った損害を賠償するものとする。ただし、開示当事者に生じた間接損害、特別損害および逸失利益については、受領当事者は責任を負わないものとする。</li>
                </ol>
            </div>
            <b for="" class="f-w6">第7条（期間）</b>
            <div class="nda-wrap">
                <ol class="ol-group">
                    <li>本契約の有効期間は、本契約の締結日から起算し、本件業務の履行が終了するまでとする。</li>
                    <li>前項にかかわらず、第2条（秘密保持義務）、第3条（管理）、第5条（秘密情報の返還および廃棄）および第6条（損害賠償等）は本契約の終了後も3年間は有効に存続する。</li>
                </ol>
            </div>
            <b for="" class="f-w6">第8条（管轄）</b>
            <div class="nda-wrap">
                <div class="content__nda__text">本契約に関する紛争については、大阪地方裁判所を第一審の専属的合意管轄裁判所とする｡ </div>
            </div>
            <b for="" class="f-w6">第9条（その他）</b>
            <div class="nda-wrap">
                <div class="content__nda__text">本契約に定めのない事項又は疑義が生じた場合、甲および乙は互いに誠意を持って協議のうえ、円滑に解決を図るものとする。</div>
            </div>
        </div>
    </div>
</body>
</html>