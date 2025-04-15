<style>
@import url('https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&family=Xanh+Mono:ital@0;1&display=swap');


.reference {
        border: 1px solid red;
        /* width: 5.83in; */
        /* height: 8.27in; */
        width: 5.5in;
        height: 8.5in;
        /* width: 148mm; */
        /* height: 210mm; */
        position: fixed;
        top: 2mm;
        left: 2mm;
        z-index: 99;
        display: none;
    }

.reference:hover {
    /* display: none; */
    z-index: -100;
    }

form {
    z-index: 99;
    position: fixed;
    top: 1rem;
    right: 1rem;
}

form label {
    display: block;
    font-size: .8rem;
}

form select {
    padding: 0.1rem;
    font-family: georgia;
}

html {
    box-sizing: border-box;
    /* font-size: 20px; */
    font-family: georgia;
    /* color: #333; */
}

body {
    position: relative;
}

* {
    box-sizing: inherit;
}

.wrapper {
    display: grid;
    grid-template-columns: max-content max-content;
    grid-template-columns: max-content;
    gap: 2rem;
}

header {
    position: relative;
}

.special-day {
    position: absolute;
    width: 10rem;
    transform-origin: 50% 50%;
    transform: translate(275px, 40px);
    /* top: 37px; */
    /* right: 92px; */
    background: yellow;
    padding: 3px 5px;
    font-size: 14px;
    box-shadow: 0 0 5px 1px #333;
    opacity: .8;
    z-index: 99;
}

.school-day {
}

.empty,
.student-info,
.school-day {
    page-break-before: always;
    break-before: page;
    /* margin: 1rem auto 0; */
    /* display: flex; */
    /* flex-direction: column; */
    /* gap: 10px; */
    padding: 5px;
    border: 1px solid #ccc;
    border-radius: 2.5px;
    /* half letter */
    width: 5.5in;
    height: 8.5in;
    /* width: 5.83in; */
    /* height: 8.27in; */
    /*  A5*/
    /* width: 148mm; */
    /* height: 210mm; */
    position:relative;
}

.student-info > *{
    margin: 0;
    text-align: center;
}

.student-info {
    padding: 1rem 1rem 0rem ;
}

.student-info h1,
.student-info h2{
    /* opacity: .8; */
    color: var(--gray9)
}

.student-info h2{
    font-size: 1.2rem;
    margin-bottom: 0;

}

.student-info h3{
    margin-top: 0;
    margin-bottom: 13rem;
    font-weight: 100;
    font-family: monospace;
    font-size: .8rem;
    /* opacity: .5; */
    color: var(--gray7)
}


header {
    /* display: flex; */
    gap: 0px 10px;
    justify-content: space-between;
    padding: 1rem 0 1.2rem 0;
    background-color: #ddd9;
    text-align: center;
    font-size: .75rem;
}

header .date {
    font-size: 3rem;
    display: block;
}

.amsa-day,
.weekday { 
    /* opacity: .5; */
    font-family: verdana;
    font-size: .75rem;
    }

.weekday {
    text-align: right;
}

.amsa-day {
    text-align: left;
}

.date {
    font-weight: bold;
    /* opacity: .8; */
}

.school-day header {
    display: grid;
    grid-template-columns: 1fr 1fr;
}

header .date {
    font-family: 'Xanh Mono';
    font-family: 'Helvetica';
    letter-spacing: -1px;
    grid-column: 1/-1;
    font-weight: 900;
    color: var(--gray7)
}

main {
    display: flex;
    flex-direction: column;
    gap: 2px;
}

.period:not(:last-of-type) {
    border-bottom: 1px solid var(--gray2);
}

.period {
    display: grid;
    grid-template-columns: max-content 1fr;
    gap: 1rem;
    padding: .8rem 1rem;
}

.period:last-of-type {
    /* border-bottom: 1px solid #333; */
}

div.school-day .period.h1,
div.school-day .period.h2 {
    /* padding-top: 0rem; */
    /* padding-bottom: 0rem; */
    background-color: #f8f8f8;
}

.school-day:nth-of-type(odd) .period {
    /* padding: .85rem 0rem .85rem 2rem ; */
}

.start-time {
    margin-top: 0.0rem;  
    margin-bottom: 0.3rem;  
}

.end-time {
    margin-top: .4rem;  
}

.end-time,
.start-time {
    font-size: .65rem;
    font-family: monospace;
    /* opacity: .6; */
}

.block-name {
    text-align: center;
    font-size: 1.25rem;
    color: var(--gray8)
}

.class-info {
    font-size: 0.8em;
    /* color: #555; */
}

.class-info span{
    display: block;
}

.class-name {
    font-size: 1.3rem;
    font-weight: 900;
    color: var(--gray8)
}

.teacher-name {
    font-style: italic;
    color:;
}

.room-number {
    /* font-weight: bold; */
    /* color: #aaa; */
}

footer {
    /* display: flex; */
    /* justify-content: center; */
    /* padding-top: 10px; */
}

.school-day-count {
    /* font-weight: 900; */
    font-size: .75em;
    /* padding-top: .5rem; */
    font-family: monospace;
    position: absolute;
    /* opacity: .25; */
    color: var(--gray2);
    width: max-content;
    position: absolute;
    top: 50rem;
    left: 31rem;
    /* transform: rotate(-90deg) */
}

main .period:nth-of-type(5) .class-info:before {
    content: 'LUNCH';
    position: absolute;
    top: 35px;
    left: 48px;
    letter-spacing: 4px;
    /* color: #333; */
    /* opacity: .5; */
    font-size: 0.5rem;
    transform: rotate(-90deg);
}

main .period {
    position: relative;

}

main .period:nth-of-type(5) .class-info {
    /* padding-top: 3rem; */
    border-left: 1.3rem solid #f0f0f0;
    /* border-left: 1.3rem solid #f00; */
    padding-left: 0.7rem !important;
}

footer  {
    /* position: relative; */
}

/* 
.school-day:nth-of-type(odd)  footer::after {
    transform: translate(-0.9rem, 0.1rem) rotate(45deg);
    content: "";
    width: 4.3rem;
    border-bottom: 1px solid #eee;
    display: block;
    position: absolute;
}

.school-day:nth-of-type(even)  footer::after {
    transform: translate(28.9rem, 0.1rem) rotate(-45deg);
    content: "";
    width: 4.3rem;
    border-bottom: 1px solid #eee;
    display: block;
    position: absolute;
}
*/

.grid-schedule tr th,
.grid-schedule thead {
    background-color: #eee;
}

.grid-schedule table th {
    padding-top: .2rem;
    padding-bottom: .2rem;
}

.grid-schedule .teacher {
    color: var(--gray7);
    font-size: .8rem;
}

.grid-schedule .block {
    text-align: right;
}

.grid-schedule .room {
    color: var(--gray7);
    /* font-weight: 900; */
    font-size: .8rem;
    text-align: left;

}

.grid-schedule td,
.grid-schedule th {
    padding: 0.6rem 1rem;
}

.grid-schedule {
    zoom:.55;
    transform: rotate(-90deg);
}

table { 
    border-collapse: collapse;
    width: 63rem;
    height: 30rem;
}

table td:first-of-type {
    /* font-weight: 900; */
}

.period {
    position: relative;
}


.br-checkbox {
    top: 50%;
}

.br-checkbox {
    position: absolute;
    right: 5px;
    /* opacity: .5; */
}

.br-checkbox input {
    display: none;
}

.br-checkbox label {
    position: relative;
    top:1rem;
    display: inline-flex;
    align-items: baseline;
    gap: 8px;
}

.br-checkbox span {
    display: inline-block;
    width: 0.5in;
    height: 0.5px;
    background-color: #555;
}


/* hide repetitive list items for long vacations, leaving start and end visible only */

.no-school-days div:nth-of-type(1) li:nth-of-type(26),
.no-school-days div:nth-of-type(1) li:nth-of-type(25),
.no-school-days div:nth-of-type(1) li:nth-of-type(24),
.no-school-days div:nth-of-type(1) li:nth-of-type(21),
.no-school-days div:nth-of-type(1) li:nth-of-type(20),
.no-school-days div:nth-of-type(1) li:nth-of-type(19),
.no-school-days div:nth-of-type(1) li:nth-of-type(15),
.no-school-days div:nth-of-type(1) li:nth-of-type(14),
.no-school-days div:nth-of-type(1) li:nth-of-type(13),
.no-school-days div:nth-of-type(1) li:nth-of-type(12),
.no-school-days div:nth-of-type(1) li:nth-of-type(11),
.no-school-days div:nth-of-type(1) li:nth-of-type(10),
.no-school-days div:nth-of-type(1) li:nth-of-type(9),
.no-school-days div:nth-of-type(1) li:nth-of-type(8) {
    display: none;
}

.no-school-days strong {
    letter-spacing: 0px;
}

.no-school-days h2 {
    padding-left: .5rem;
    font-family: georgia;
    letter-spacing: 0px;
    text-transform: capitalize;
    /* color: #3339; */
    border-bottom: 3px solid #3335;
    padding-bottom: 5px;
}

.no-school-days div {
    padding: 0 1rem;
}

.no-school-days div:nth-of-type(3) {
    grid-column: 2/3;
    grid-row: 1/2;
}

.no-school-days strong {
    margin-right: 10px;
}

.no-school-days li {
    margin-bottom: 3px;
}

.no-school-days ul {
    padding-left: 1.5rem;
    list-style-type: none;
}

.no-school-days {
    padding-top: 4rem;
    font-size: .65rem;
    letter-spacing: 1px;
    display: grid;
    grid-template-columns: 1fr 1fr;
    font-family: 'PT Sans Narrow';
}

img:nth-of-type(1),
img:nth-of-type(2) {
    width: 4rem;
    position: absolute;
    opacity: .5;
    /* border: 1px solid #ddd; */
}

img:nth-of-type(1) {left: 1rem;}
img:nth-of-type(2) {right: 1rem;}

.back-logo img {
    width: 50%;
    position: absolute;
    top: 80%;
    left: 25%;
    border: 1px solid #ddd;
}

/* DS Pass on H1 and H2 */


.h1 .class-info:after ,
.h2 .class-info:after ,
.h1:before,
.h1:after,
.h2:before,
.h2:after {
    /* opacity: .25; */
    top: 2.5rem;
    font-size: .7rem;
}

.h1 .class-info:after ,
.h2 .class-info:after {
    content: 'DS Pass';
    position: absolute;
    left: 12rem;
}

.h1:before,
.h2:before {
    content: 'Left DS';
    /* background-color: red; */
    position: absolute;
    left: 17rem;
}

.h1:after,
.h2:after {
    content: 'Back to DS';
    /* background-color: red; */
    position: absolute;
    left: 22rem;
}


@media print {

    .student-info,
    .school-day,
    .school-day:empty {
        border-color: transparent !important;
    }

    body {
        margin: 0;
        padding: 0;
    }

    .wrapper {
        /* margin: 0; */
    }

    .school-day {
        margin: 2mm 0 0 2mm;
        /* margin-top:2rem; */
        /* width: 100%; */
    }

    .empty,
    .student-info,
    .school-day {
        /* margin-top: 2rem; */
        /* width: 100%; */
        /* zoom: .96; */
        /* margin: 0rem 0rem 0rem 1rem; */
        page-break-after: always;
    }
    
    /* Hide unnecessary elements on print */
    .no-print {
        display: none;
    }
}

div.school-day::after {
    content: '';
    border: 1px solid var(--gray1);
    position: absolute;
    width: 3.7rem;
    right: 0rem;
    transform: rotate(-45deg) translate(18px, -4px);
}

div.school-day:nth-of-type(1)::after, 
div.school-day:nth-of-type(2)::after,
div.school-day:nth-of-type(4)::after, 
div.school-day:nth-of-type(3)::after {
    border-color: transparent;
}

</style>