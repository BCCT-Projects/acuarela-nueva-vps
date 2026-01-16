// import { io } from "https://cdn.socket.io/4.7.5/socket.io.esm.min.js";
var today = new Date();
var dd = String(today.getDate()).padStart(2, "0");
var mm = String(today.getMonth() + 1).padStart(2, "0"); //January is 0!
var yyyy = today.getFullYear();
// Obtiene la fecha actual.
today = yyyy + "-" + mm + "-" + dd;
const time = formatTime(new Date());
let reactions = [
  {
    id: 1,
    name: "Me gusta",
    icon: "img/caras/happy.svg",
  },
  {
    id: 2,
    name: "Me encanta",
    icon: "img/caras/stars.svg",
  },
  {
    id: 3,
    name: "Me sorprende",
    icon: "img/caras/surprised.svg",
  },
  {
    id: 4,
    name: "Me enorgullece",
    icon: "img/caras/veryHappy.svg",
  },
];
const activitiesList = [
  {
    id: "6088935af169a43504538925",
    name: "Alimentación",
    bgcolor: "rgba(235, 93, 94, 0.3)",
    color: "rgb(235, 93, 94)",
    width: 44,
    height: 45,
    rate: 0,
    icon: '<svg width="44" height="45" viewBox="0 0 44 45" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)"><path d="M14.2008 27.6599C14.0159 27.6754 13.8314 27.6834 13.6465 27.6834C13.1408 27.6834 12.6488 27.6101 12.1671 27.4986L1.02068 38.6453C0.473575 39.1916 0.473575 40.079 1.02068 40.6254L3.90548 43.5109C4.45259 44.0573 5.339 44.0573 5.8846 43.5109L19.2811 30.1169L16.7984 27.4382L14.2008 27.6599Z" fill="#EB5D5E"/><path d="M43.5343 9.80251C43.0112 9.27966 42.1646 9.27966 41.6416 9.80251L34.4182 17.0257C33.7347 17.7085 32.6276 17.7085 31.9441 17.0257C31.2636 16.3435 31.2636 15.2373 31.9441 14.5552L39.1318 7.36905C39.6748 6.82549 39.6748 5.94433 39.1318 5.39953C38.5862 4.85669 37.7054 4.85669 37.1623 5.39953L29.9776 12.585C29.2941 13.2684 28.1883 13.2684 27.5048 12.585C26.8227 11.903 26.8227 10.796 27.5048 10.1145L34.7267 2.89205C35.2512 2.3684 35.2512 1.5202 34.7267 0.995834C34.2035 0.472092 33.3554 0.472092 32.8309 0.995834L24.7053 9.12187C22.7517 11.0767 22.1345 13.8207 22.767 16.3175L28.2141 21.765C30.7108 22.3951 33.4561 21.7778 35.4075 19.8245L43.5342 11.6989C44.0589 11.1753 44.0589 10.3262 43.5343 9.80251Z" fill="#EB5D5E"/><path d="M4.06445 1.73008C3.78601 1.45155 3.40948 1.29883 3.02283 1.29883C2.94056 1.29883 2.85784 1.30585 2.77708 1.31935C2.30665 1.39896 1.90302 1.70094 1.69566 2.13077C-0.684501 7.05039 0.310209 12.9371 4.1739 16.801L11.0861 23.7123C11.7681 24.3951 12.6902 24.773 13.6466 24.773C13.7488 24.773 13.8514 24.7688 13.9536 24.7603L17.9668 24.4178L35.4667 43.2964C35.7384 43.5899 36.119 43.7603 36.52 43.7682C36.5283 43.7682 36.5369 43.7682 36.5456 43.7682C36.9376 43.7682 37.3129 43.6133 37.5914 43.3368L40.5885 40.3391C40.8654 40.0628 41.0202 39.6878 41.0202 39.297C41.0202 38.9062 40.8654 38.5309 40.5896 38.2546L4.06445 1.73008Z" fill="#EB5D5E"/></g><defs><clipPath id="clip0"><rect width="43.5139" height="43.5139" fill="white" transform="translate(0.413574 0.504883)"/></clipPath></defs></svg>',
    iconClass: "acuarela-Alimentacion",
  },

  {
    id: "60889371f169a43504538926",
    name: "Siesta",
    bgcolor: "rgba(12, 181, 195, 0.3)",
    color: "rgb(12, 181, 195)",
    width: 42,
    height: 45,
    rate: 0,
    icon: '<svg width="42" height="45" viewBox="0 0 42 45" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M10.1155 21.2196C13.1437 21.2196 15.9441 21.2179 18.7461 21.2213C19.5113 21.2213 20.2764 21.2144 21.0262 21.4061C22.4579 21.7722 23.3556 22.8825 23.291 24.2101C23.2196 25.6729 22.327 26.6789 20.7848 26.8602C18.4724 27.1323 16.1464 26.956 13.8255 26.968C10.5405 26.9851 7.25556 26.9817 3.9706 26.9543C2.32641 26.9406 1.0716 26.2649 0.466291 24.6344C0.0463191 23.5018 0.326867 22.4514 0.938973 21.4916C1.36405 20.8244 1.87753 20.2068 2.39272 19.6028C5.91063 15.4694 9.43874 11.3446 12.9617 7.21629C13.1607 6.98362 13.3477 6.74239 13.5432 6.50116C13.295 6.24282 13.0264 6.3506 12.7934 6.34889C10.243 6.3352 7.69424 6.33863 5.1455 6.33863C4.51809 6.33863 3.90258 6.27875 3.31088 6.05292C2.06627 5.57559 1.41165 4.60212 1.46096 3.29332C1.50687 2.07177 2.2652 1.08804 3.45371 0.701386C3.94679 0.540566 4.45348 0.50806 4.96357 0.50635C9.49315 0.504639 14.0244 0.502928 18.5557 0.50806C19.0352 0.50806 19.5198 0.538856 19.9959 0.607289C22.9731 1.04356 24.2024 3.72103 22.6313 6.32665C22.1144 7.18378 21.47 7.93998 20.8222 8.69617C17.5491 12.5165 14.2761 16.3351 11.003 20.1554C10.7497 20.4531 10.5014 20.7559 10.1155 21.2196Z" fill="#0CB5C3"/><path d="M35.074 19.3719C33.1306 19.3719 31.2653 19.4027 29.4001 19.3616C27.8937 19.3291 27.0605 18.2376 27.472 16.9459C27.6386 16.4224 27.9719 16.0597 28.4718 15.8561C28.6537 15.7825 28.8509 15.7106 29.0431 15.7055C32.5797 15.6063 36.1214 15.4455 39.6461 15.7911C41.1304 15.9365 41.7817 17.5276 41.1491 19.0468C40.8924 19.661 40.4588 20.1554 40.0355 20.6516C37.8914 23.1563 35.7422 25.6558 33.5998 28.1622C33.4264 28.3658 33.1646 28.5249 33.1374 28.9406C34.8445 28.9406 36.5311 28.9423 38.2178 28.9406C38.784 28.9406 39.3519 28.9406 39.9062 29.0792C40.8533 29.317 41.4416 30.0287 41.4025 30.8927C41.3634 31.7601 40.8057 32.3743 39.8637 32.5625C39.5883 32.6172 39.3026 32.6515 39.0221 32.6532C35.7371 32.66 32.4521 32.66 29.1655 32.6566C28.2099 32.6549 27.3411 32.4171 26.8837 31.4778C26.3906 30.4684 26.6286 29.5172 27.3224 28.696C29.7062 25.8731 32.1121 23.069 34.5044 20.2529C34.6999 20.0168 34.9635 19.8269 35.074 19.3719Z" fill="#0CB5C3"/><path d="M13.9666 41.5631C15.1942 41.5631 16.2059 41.5631 17.2158 41.5631C17.5559 41.5631 17.8959 41.5512 18.2343 41.5768C19.0811 41.6384 19.5877 42.1157 19.5758 42.8172C19.5639 43.5392 19.0743 43.9925 18.2054 44.0028C16.3657 44.025 14.5277 44.0165 12.6879 44.0182C12.2357 44.0182 11.7817 44.0165 11.3294 44.0113C10.7258 44.0045 10.1868 43.8232 9.91307 43.25C9.62062 42.6358 9.70904 42.0182 10.1443 41.4913C10.9741 40.4836 11.8208 39.4879 12.6641 38.4922C13.4344 37.582 14.2114 36.6769 14.9816 35.7651C15.0854 35.6419 15.2775 35.529 15.2146 35.3459C15.1296 35.0944 14.8779 35.1936 14.6994 35.1919C13.737 35.1782 12.7747 35.1988 11.814 35.1765C10.77 35.1526 10.2497 34.7026 10.265 33.8866C10.2803 33.1167 10.7938 32.7044 11.8072 32.6975C13.7591 32.6838 15.7128 32.6804 17.6647 32.6924C18.3567 32.6975 19.0777 32.7745 19.4177 33.4913C19.7884 34.2698 19.5401 34.9935 19.0045 35.6231C17.5525 37.3322 16.0919 39.0362 14.6382 40.7436C14.4597 40.9541 14.2862 41.1748 13.9666 41.5631Z" fill="#0CB5C3"/></svg>',
    iconClass: "acuarela-Siesta",
  },

  {
    id: "6088937ff169a43504538927",
    name: "Baño",
    bgcolor: "rgba(240, 134, 47, 0.3)",
    color: "rgb(240, 134, 47)",
    width: 45,
    height: 45,
    rate: 0,
    icon: '<svg width="45" height="45" viewBox="0 0 45 45" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M28.3412 36.4452C28.3412 37.9206 28.3464 39.3417 28.3399 40.7615C28.3321 42.7309 27.0478 43.9943 25.085 43.9904C21.8353 43.9852 18.5842 43.9167 15.3384 44.0175C13.3613 44.0783 11.9522 42.5848 11.9847 40.6684C12.0367 37.7176 12.0107 34.7642 11.9795 31.812C11.9756 31.4732 11.8027 31.0556 11.5648 30.8125C9.98545 29.1909 8.64916 27.4065 7.65605 25.3685C6.9593 23.9384 7.49226 23.0617 9.10413 23.0617C19.0678 23.0591 29.0328 23.063 38.9965 23.063C40.0364 23.063 41.0763 23.0513 42.1162 23.0617C43.4603 23.0733 44.0375 23.9733 43.4525 25.1875C40.4718 31.3788 35.5518 35.059 28.7962 36.3521C28.6727 36.3766 28.5479 36.4038 28.3412 36.4452Z" fill="#F0862F"/><path d="M5.40339 2.86803C5.2734 2.59777 5.16031 2.41544 5.09402 2.2176C4.81454 1.38097 5.3644 0.563731 6.25222 0.522352C6.85667 0.493904 7.46502 0.505542 8.07077 0.51718C9.24718 0.539163 9.80743 1.50252 9.24718 2.52665C9.19908 2.61458 9.15098 2.7038 9.06129 2.86673C10.0011 2.86673 10.8616 2.85897 11.7235 2.86803C12.7738 2.87837 13.2703 3.38009 13.2703 4.4262C13.2742 9.42402 13.2755 14.4231 13.2755 19.4209C13.2755 20.6946 12.8414 21.1123 11.5454 21.1097C9.66184 21.1071 7.777 21.1058 5.89345 21.1007C4.94323 21.0981 4.52077 20.7567 4.31408 19.8244C3.20267 14.7813 2.09127 9.73824 0.981157 4.69258C0.735477 3.57793 1.29053 2.87966 2.43314 2.86932C3.40026 2.86156 4.36868 2.86803 5.40339 2.86803Z" fill="#F0862F"/><path d="M30.0117 21.2268C25.9625 21.2268 21.9146 21.2294 17.8655 21.2255C16.5539 21.2242 15.6556 20.4729 15.5672 19.3337C15.4698 18.0833 16.3732 17.0967 17.69 17.0824C19.8985 17.0592 22.107 17.0734 24.3155 17.0734C30.2482 17.0734 36.181 17.0773 42.1124 17.0721C42.9001 17.0708 43.5709 17.2958 44.0297 17.9527C44.4821 18.5992 44.5835 19.2975 44.2156 20.0268C43.8178 20.8156 43.164 21.2178 42.2879 21.2216C40.0793 21.2333 37.8708 21.2255 35.6623 21.2255C33.7788 21.2255 31.8952 21.2255 30.0117 21.2255V21.2268Z" fill="#F0862F"/></svg>',
    iconClass: "acuarela-Bano",
  },

  {
    id: "6088938ff169a43504538928",
    name: "Juego",
    bgcolor: "rgba(245, 170, 22, 0.3)",
    color: "rgb(245, 170, 22)",
    width: 44,
    height: 44,
    rate: 0,
    icon: '<svg width="44" height="44" viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.1705 0.200928C10.1537 0.200928 0.413574 9.94108 0.413574 21.9579C0.413574 33.9747 10.1537 43.7149 22.1705 43.7149C34.1873 43.7149 43.9275 33.9747 43.9275 21.9579C43.9275 9.94108 34.1873 0.200928 22.1705 0.200928ZM24.1802 7.02702L28.866 4.65875C29.059 4.56129 29.2871 4.55544 29.4839 4.6451C30.6885 5.19088 35.0333 7.36423 37.4055 11.3367C37.501 11.4985 37.5283 11.6915 37.4834 11.8747L36.501 15.851C36.4504 16.0596 36.3081 16.2331 36.1151 16.3267L31.6495 18.4844C31.4117 18.5994 31.131 18.5741 30.9166 18.4201L24.0846 13.5023C23.8975 13.3678 23.7864 13.1495 23.7864 12.9195V7.66831C23.7864 7.39737 23.9385 7.14982 24.1802 7.02702ZM15.3678 4.65875L20.1551 7.02702C20.4007 7.14787 20.5546 7.39737 20.5546 7.67221V12.9701C20.5546 13.206 20.4396 13.4262 20.2467 13.5607L13.2491 18.4337C13.0366 18.5819 12.7618 18.6033 12.5278 18.4922L8.11096 16.3812C7.91799 16.2896 7.77765 16.1161 7.72502 15.9115L6.69389 11.8825C6.64516 11.6954 6.67245 11.4965 6.77381 11.3309C9.107 7.54161 13.5219 5.23766 14.7402 4.65485C14.939 4.55934 15.171 4.56129 15.3678 4.65875ZM6.36253 31.8267C5.66472 30.8131 3.36856 27.0141 3.54204 21.1529C3.54984 20.9112 3.68043 20.6909 3.88705 20.5662L6.26897 19.1101C6.48533 18.9776 6.75432 18.9698 6.97848 19.0867L11.1264 21.2601C11.2862 21.3439 11.411 21.4862 11.4714 21.6577L14.4615 30.1036C14.5511 30.355 14.4926 30.6357 14.3114 30.8326L12.7579 32.5128C12.6019 32.6804 12.3758 32.7642 12.1478 32.7389L6.87517 32.1366C6.66855 32.1113 6.48143 32.0002 6.36253 31.8267ZM26.4841 40.3193C25.2288 40.5123 20.9542 41.0561 17.6737 40.1205C17.4866 40.0679 17.3326 39.9354 17.243 39.7638L14.8513 35.1754C14.7071 34.8967 14.7577 34.5556 14.9799 34.3353L16.3229 32.9923C16.4574 32.8578 16.6407 32.7818 16.8317 32.7818H27.5113C27.7024 32.7818 27.8856 32.8578 28.0201 32.9923L29.3631 34.3353C29.5853 34.5575 29.6379 34.8967 29.4917 35.1754L27.0123 39.9412C26.9051 40.1439 26.7102 40.2843 26.4841 40.3193ZM31.8093 32.5109L30.2539 30.8287C30.0745 30.6338 30.0161 30.357 30.1018 30.1055L32.9262 21.8955C32.9886 21.7162 33.1172 21.568 33.2868 21.4842L37.5926 19.3557C37.8148 19.2466 38.0779 19.2582 38.2885 19.3888L40.7289 20.8975C40.9413 21.0301 41.07 21.262 41.07 21.5135C41.0641 22.9695 40.8322 28.0257 38.0214 31.852C37.9045 32.0099 37.7251 32.1113 37.5302 32.1347L32.4214 32.735C32.1933 32.7642 31.9653 32.6804 31.8093 32.5109Z" fill="#F5AA16"/></svg>',
    iconClass: "acuarela-Salud",
  },

  {
    id: "6088939df169a43504538929",
    name: "Salud",
    bgcolor: "rgba(63, 176, 114, 0.3)",
    color: "rgb(63, 176, 114)",
    width: 48,
    height: 44,
    rate: 0,
    icon: '<svg width="48" height="44" viewBox="0 0 48 44" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M34.4266 29.0757C33.4551 29.0757 32.6121 28.3857 32.4029 27.4142L30.6941 19.4814L26.042 34.8454C25.7768 35.7238 24.9856 36.3248 24.0867 36.3354C24.0784 36.3354 24.0701 36.3354 24.0618 36.3354C23.1732 36.3354 22.382 35.7555 22.0982 34.892L19.0182 25.5009L17.5683 28.028C17.1976 28.6757 16.5161 29.0757 15.7808 29.0757H9.53584C8.39249 29.0757 7.46455 28.1275 7.46455 26.9592C7.46455 25.7908 8.39249 24.8426 9.53584 24.8426H14.5939L17.7464 19.3439C18.1566 18.6285 18.9437 18.2242 19.7473 18.3089C20.5551 18.3935 21.2407 18.9544 21.4976 19.7418L23.981 27.319L29.0495 10.5835C29.327 9.66492 30.1763 9.05324 31.1146 9.09558C32.0549 9.13579 32.8482 9.81732 33.0512 10.7549L36.0877 24.8426H43.9545C46.5374 20.9482 48.1468 16.7617 47.5316 11.7455C46.5623 3.84444 38.9668 -1.59718 31.4273 0.434698C28.424 1.24322 25.9736 2.89835 23.9479 5.30062C23.8112 5.25406 23.7698 5.25194 23.7491 5.23077C23.5336 5.00219 23.3244 4.76937 23.109 4.5429C19.8364 1.14374 15.8906 -0.549493 11.2364 0.191296C4.64759 1.23898 0.335159 6.488 0.0555341 13.3816C-0.093599 17.0876 1.04561 20.4021 2.93463 23.4563C8.12943 31.8632 15.5302 37.9334 23.4508 43.4258C23.6558 43.5676 24.1177 43.5422 24.3414 43.4004C25.2777 42.8078 26.1807 42.158 27.0735 41.4977C30.4994 38.9621 33.801 36.2867 36.8251 33.3151H44.8327C45.9761 33.3151 46.904 32.3669 46.904 31.1986C46.904 30.0303 45.9761 29.082 44.8327 29.082H40.7502C40.7523 29.0799 40.7523 29.0778 40.7544 29.0757H34.4266Z" fill="#3FB072"/></svg>',
    iconClass: "",
  },

  {
    id: "608893aef169a4350453892a",
    name: "Actividades",
    bgcolor: "rgba(123, 97, 255, 0.3)",
    color: "rgb(123, 97, 255)",
    width: 50,
    height: 44,
    rate: 0,
    icon: '<svg width="50" height="44" viewBox="0 0 50 44" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M23.085 43.715C13.6577 43.1716 2.85609 37.3061 0.965912 24.5828C0.398858 20.7591 0.861558 17.1205 2.24966 13.5942C4.56119 7.71885 9.11338 4.55674 15.1167 3.14895C18.33 2.39484 21.3346 3.05247 24.1954 4.36378C27.9384 6.07873 29.3856 9.63857 28.0388 13.543C27.5722 14.8937 26.7807 16.1302 26.2018 17.4474C25.7174 18.55 25.1031 19.6605 24.9377 20.8221C24.5538 23.5196 26.9421 26.0753 30.0137 26.3509C31.004 26.4395 32.0515 26.3371 33.0242 26.1107C34.5304 25.7602 35.5247 24.76 36.0012 23.2557C36.3832 22.0508 37.3204 21.3026 38.4033 21.2592C39.4764 21.2159 40.3683 21.9405 40.8861 23.1553C42.038 25.8508 41.5241 28.5128 40.6951 31.1315C38.3856 38.4264 33.1285 42.189 25.7824 43.3704C24.7192 43.5378 23.6441 43.6421 23.085 43.715ZM15.9692 32.1731C15.9633 30.0722 14.335 28.4065 12.2755 28.3986C10.0978 28.3907 8.36124 30.1155 8.4085 32.242C8.45378 34.2779 10.149 35.9003 12.242 35.9101C14.3133 35.918 15.9732 34.2542 15.9692 32.1731ZM22.321 40.9722C24.4888 40.986 26.1644 39.3754 26.1801 37.2647C26.1959 35.2151 24.5065 33.5198 22.447 33.5178C20.2773 33.5159 18.6174 35.1166 18.5918 37.2372C18.5643 39.2888 20.232 40.9585 22.321 40.9722ZM32.5241 28.3848C30.4882 28.3907 28.8008 30.0978 28.8008 32.1514C28.8008 34.2582 30.5118 35.9751 32.5989 35.9633C34.6328 35.9515 36.3162 34.2326 36.3103 32.1731C36.3044 30.019 34.6623 28.3769 32.5241 28.3848ZM10.8559 22.0626C10.8677 19.9499 9.24136 18.2133 7.22123 18.1798C5.12628 18.1463 3.39164 19.8554 3.37983 21.9641C3.36802 24.0925 5.0554 25.7937 7.17004 25.7858C9.16063 25.778 10.846 24.0768 10.8559 22.0626ZM12.3129 8.07523C10.086 8.05554 8.48726 9.59131 8.46166 11.7749C8.43803 13.8383 10.0329 15.5139 12.055 15.5493C14.2956 15.5887 15.9554 13.988 15.9613 11.7867C15.9653 9.72323 14.3645 8.09295 12.3129 8.07523Z" fill="#7B61FF"/><path d="M28.736 24.2797C27.1648 21.4503 27.1629 15.5868 31.1185 13.3363C32.6385 12.472 34.1447 12.3027 35.6391 13.358C36.98 14.3031 37.6829 16.2012 37.3265 17.796C37.0706 18.936 36.4228 19.7787 35.3241 20.1627C32.9004 21.0093 30.7522 22.2674 28.9881 24.1537C28.927 24.2167 28.8207 24.2384 28.736 24.2797Z" fill="#7B61FF"/><path d="M47.5999 0.201357C48.862 0.183637 49.3896 0.713281 49.2538 1.91236C49.0569 3.62928 48.2811 5.1493 47.1116 6.35429C45.3848 8.13421 43.5143 9.7763 41.6478 11.4145C41.4272 11.6094 40.7342 11.5641 40.4723 11.3593C39.73 10.7785 39.0448 10.0992 38.4502 9.36676C38.2277 9.09111 38.1312 8.45318 38.2966 8.16571C40.2518 4.75748 42.9236 2.08957 46.5504 0.461257C46.7572 0.368717 46.9796 0.303742 47.2021 0.248612C47.3597 0.209233 47.527 0.209233 47.5999 0.201357Z" fill="#7B61FF"/><path d="M37.8758 14.3286C37.4781 14.0136 37.0863 13.7498 36.7496 13.4288C35.3202 12.0663 35.3261 12.0604 36.5212 10.4734C37.2694 9.47913 37.2635 9.48701 38.1298 10.31C38.7225 10.8731 39.3348 11.4166 39.9511 11.9541C40.4965 12.4286 40.5497 12.911 39.9117 13.2989C39.3053 13.671 38.6418 13.9467 37.8758 14.3286Z" fill="#7B61FF"/></svg>',
    iconClass: "acuarela-Actividades",
  },
];
let fetching = false; // Variable para controlar si se está realizando una solicitud
let page = 1; // Inicializamos la página en 1
const manualHandle = async (parentId, parentName, parentEmail, code) => {
  fadeIn(preloader);

  let data = {};

  // Verificar si el tipo de operación es checkout o no
  if (typeCheck === "checkout") {
    data = {
      children: [kid.id],
      datetime: today,
      acudiente: [parentId],
      code, // Incluir el código si es checkout
    };
  } else {
    data = {
      children: [kid.id],
      datetime: today,
      acudiente: [parentId],
    };
  }

  const raw = JSON.stringify(data);
  const requestOptions = {
    method: "POST",
    body: raw,
  };

  try {
    const response = await fetch(
      `s/setAsistencia/?type=${typeCheck}`,
      requestOptions
    );
    const result = await response.json();

    const infoLightbox = document.getElementById("info-lightbox");
    infoLightbox.style.display = "none";

    // Enviar correo de confirmación (basado en el tipo de registro: check-in o check-out)
    sendEmailRegisterCheck(
      kid.name,
      parentName,
      daycareName,
      parentName,
      parentEmail,
      typeCheck
    );

    // Actualizar la lista de niños
    getChildren();
  } catch (error) {
    console.error("Error en el proceso de registro:", error);
  } finally {
    fadeOut(preloader);
  }
};

const sendRegisterEmail = async (rol, daycare, email, link, kid) => {
  let mailUrl = `https://bilingualchildcaretraining.com/s/endRegister/?rol=${rol}&daycare=${daycare}&email=${email}&link=${link}&kid=${kid}`;

  await fetch(mailUrl, {
    method: "GET",
    headers: {
      "content-type": "multipart/form-data",
    },
  })
    .then((response) => response.json())
    .then((result) => result)
    .catch((error) => console.log("Invitation no sended ", error));
};
const baseUrl = "https://acuarelacore.com/api";

// Función para validar formato de email
const isValidEmail = (email) => {
  if (!email || email.trim() === "") return false;
  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailRegex.test(email.trim());
};

const handleInscripcion = async () => {
  fadeIn(preloader);
  let isComplete = updatePercentage() === 100;
  const form = document.getElementById("inscription");
  const inputs = form.querySelectorAll("input, select, textarea");

  const formValues = {};
  inputs.forEach((input) => {
    formValues[input.name] = input.value;
  });

  // Validar emails antes de continuar
  const emailFields = [
    { name: "parent_email1", value: formValues.parent_email1, required: true, label: "Correo del Padre 1" },
    { name: "parent_email2", value: formValues.parent_email2, required: false, label: "Correo del Padre 2" },
    { name: "guardian1_email", value: formValues.guardian1_email, required: true, label: "Correo del Responsable 1" },
    { name: "guardian2_email", value: formValues.guardian2_email, required: false, label: "Correo del Responsable 2" }
  ];

  for (const emailField of emailFields) {
    if (emailField.required && (!emailField.value || emailField.value.trim() === "")) {
      fadeOut(preloader);
      Swal.fire({
        title: "Campo obligatorio",
        text: `${emailField.label} es obligatorio`,
        icon: "error",
        confirmButtonText: "Entendido",
        background: "#f0feff",
        color: "#333",
        confirmButtonColor: "#0cb5c3",
      }).then(() => {
        const input = document.getElementById(emailField.name);
        if (input) {
          input.focus();
          input.reportValidity();
        }
      });
      return;
    }

    if (emailField.value && emailField.value.trim() !== "" && !isValidEmail(emailField.value)) {
      fadeOut(preloader);
      Swal.fire({
        title: "Formato inválido",
        text: `${emailField.label} no tiene un formato válido. Por favor ingresa un correo electrónico válido (ejemplo: correo@dominio.com)`,
        icon: "error",
        confirmButtonText: "Entendido",
        background: "#f0feff",
        color: "#333",
        confirmButtonColor: "#0cb5c3",
      }).then(() => {
        const input = document.getElementById(emailField.name);
        if (input) {
          input.focus();
          input.reportValidity();
        }
      });
      return;
    }
  }





  const files = [
    {
      name: "acuerdo-de-registro",
      file: formValues["acuerdo-de-registro-id"],
    },
    {
      name: "formulario-de-examen-de-salud",
      file: formValues["formulario-de-examen-de-salud-id"],
    },
    {
      name: "formato-de-alergias",
      file: formValues["formato-de-alergias-id"],
    },
    {
      name: "id-de-los-padres",
      file: formValues["id-de-los-padres-id"],
    },
    {
      name: "plan-de-transporte",
      file: formValues["plan-de-transporte-id"],
    },
    {
      name: "acuerdo-de-siestas",
      file: formValues["acuerdo-de-siestas-id"],
    },
    {
      name: "archivos-adicionales",
      file: formValues["archivos-adicionales-id"],
    },
  ];

  // Convertir emails a minúsculas antes de guardar
  const normalizeEmail = (email) => {
    return email && email.trim() !== "" ? email.trim().toLowerCase() : email;
  };

  const parents = [
    {
      email: normalizeEmail(formValues.parent_email1),
      is_principal: true,
      lastname: formValues.parent_lastname1,
      name: formValues.parent_name1,
      parent_type: formValues.parent_type1,
      phone: formValues.parent_phone1,
      work_phone: formValues.parent_phone1,
    },
    {
      email: normalizeEmail(formValues.parent_email2),
      is_principal: false,
      lastname: formValues.parent_lastname2,
      name: formValues.parent_name2,
      parent_type: formValues.parent_type2,
      phone: formValues.parent_phone2,
      work_phone: formValues.parent_phone2,
    },
  ];
  const guardians = [
    {
      guardian_name: formValues.guardian1_name,
      guardian_relationship: formValues.guardian1_relationship,
      guardian_phone: formValues.guardian1_phone,
      guardian_email: normalizeEmail(formValues.guardian1_email),
      guardian_pickup: formValues.guardian1_emergency == "on" ? true : false,
      guardian_emergency: formValues.guardian1_pickup == "on" ? true : false,
      guardian_lastname: formValues.guardian1_lastname,
    },
    {
      guardian_name: formValues.guardian2_name,
      guardian_relationship: formValues.guardian2_relationship,
      guardian_phone: formValues.guardian2_phone,
      guardian_email: normalizeEmail(formValues.guardian2_email),
      guardian_pickup: formValues.guardian2_emergency == "on" ? true : false,
      guardian_emergency: formValues.guardian2_pickup == "on" ? true : false,
      guardian_lastname: formValues.guardian2_lastname,
    },
  ];

  let dataToSend = {
    name: formValues.name,
    lastname: formValues.lastname,
    birthdate: formValues.birthdate ? formValues.birthdate : today,
    gender: formValues.genero,
    daycare: formValues.daycare,
    files: files.filter((file) => file.file),
    parents: parents.filter((parent) => parent.email),
    guardians,
    payment: {
      time: formValues.paymentTime,
      price: formValues.paymentPrice,
      proximo_pago: formValues.proximo_pago ? formValues.proximo_pago : today,
    },
    inscription_date: new Date(),
    percentaje: isComplete ? 100 : updatePercentage(),
    status: isComplete ? "Finalizado" : "Borrador",
    inscripcion: formValues.inscripcion ? formValues.inscripcion : "",
    coppa_notice_version: formValues.coppa_notice_version || "",
    coppa_consent: isComplete && formValues.coppa_consent ? true : false,
  };

  try {
    if (formValues.inscripcion == "") {
      if (isComplete) {
        const response = await fetch("s/createInscripcion/", {
          method: "POST",
          body: JSON.stringify(dataToSend),
          headers: { "Content-Type": "application/json" },
        });
        const body = await response.json();

        // Primero procesar la respuesta normal (enviar invitaciones)
        const success = await processResponse(body, dataToSend, formValues);

        // Redirigir directamente sin mostrar alert (se recarga muy rápido)
        if (success) {
          window.location.href = `/miembros/acuarela-app-web/inscripciones`;
        } else {
          // Manejo de errores en caso de que processResponse falle
        }
        async function sendEmailsToParents(parents, daycare, formValues) {
          const emailPromises = parents.map((parent) => {
            return sendRegisterEmail(
              "Padre",
              daycare,
              parent.email,
              `https://acuarelacore.com/auth/register/${parent.id}`,
              formValues.name
            );
          });

          try {
            await Promise.all(emailPromises);
          } catch (error) {
            console.error("Error sending emails:", error);
            throw error;
          }
        }

        async function processResponse(body, dataToSend, formValues) {
          if (!body.ok) {
            return false;
          }

          if (dataToSend.parents && dataToSend.parents.length > 0) {
            try {
              await sendEmailsToParents(
                body.parents,
                foundDaycare.name,
                formValues
              );
              fadeOut(preloader);
            } catch (error) {
              // Handle error if necessary
              return false;
            }
          }

          window.location.href = `/miembros/acuarela-app-web/inscripciones`;
          return true;
        }

        return false;
      } else {
        dataToSend.daycare = formValues.daycare;
        const response = await fetch("s/createInscripcion/", {
          method: "POST",
          body: JSON.stringify(dataToSend),
          headers: { "Content-Type": "application/json" },
        });
        const body = await response.json();
        fadeOut(preloader);
        window.location.href = `/miembros/acuarela-app-web/inscripciones`;
        return body || false;
      }
    } else {
      if (isComplete) {
        const response = await fetch("s/updateInscripcion/", {
          method: "POST",
          body: JSON.stringify(dataToSend),
          headers: { "Content-Type": "application/json" },
        });
        const body = await response.json();

        if (body.ok) {
          fadeOut(preloader);
          window.location.href = `/miembros/acuarela-app-web/inscripciones`;
          return true;
        }
        return false;
      } else {
        dataToSend.daycare = formValues.daycare;
        const response = await fetch("s/updateInscripcion/", {
          method: "POST",
          body: JSON.stringify(dataToSend),
          headers: { "Content-Type": "application/json" },
        });
        const body = await response.json();
        fadeOut(preloader);
        window.location.href = `/miembros/acuarela-app-web/inscripciones`;
        return body || false;
      }
    }
  } catch (error) {
    console.error("Error handling inscripcion:", error);
    return false;
  }
};

const fetchToken = async (endpoint, data, method = "GET") => {
  const url = `${baseUrl}/${endpoint}`;

  const headers = {
    "Content-type": "application/json",
    token: userMainT,
  };

  const options =
    method === "GET"
      ? { method, headers }
      : {
        method,
        headers,
        body: JSON.stringify(data),
      };

  try {
    const response = await fetch(url, options);
    return response;
  } catch (error) {
    console.error(`Error fetching ${endpoint}:`, error);
    throw error;
  }
};

function formatFechaAmigable(fechaOriginal) {
  const fecha = new Date(fechaOriginal);
  const ahora = new Date();
  const diferenciaMs = ahora - fecha;
  const diferenciaSegundos = Math.floor(diferenciaMs / 1000);
  const diferenciaMinutos = Math.floor(diferenciaSegundos / 60);
  const diferenciaHoras = Math.floor(diferenciaMinutos / 60);
  const diferenciaDías = Math.floor(diferenciaHoras / 24);

  if (diferenciaSegundos < 60) {
    return "hace poco";
  } else if (diferenciaMinutos < 60) {
    return `hace ${diferenciaMinutos} minutos`;
  } else if (diferenciaHoras < 24) {
    return `hace ${diferenciaHoras} horas`;
  } else if (diferenciaDías < 7) {
    return `hace ${diferenciaDías} días`;
  } else {
    const año = fecha.getFullYear();
    const mes = String(fecha.getMonth() + 1).padStart(2, "0");
    const día = String(fecha.getDate()).padStart(2, "0");
    return `${año}-${mes}-${día}`;
  }
}

const toggleMenu = () => {
  document.querySelector("aside").classList.toggle("active");
  document.querySelector("body").classList.toggle("activeMenu");
};
const addReaction = async (body, element) => {
  let postArticle = document.getElementById(element);
  let buttonsAndIcons = postArticle.querySelector(".reactions-actions button");

  let children = buttonsAndIcons.children;

  if (children.length > 0) {
    let childTag = children[0].tagName;
    if (childTag === "IMG") {
      children[0].src = reactions.find(
        (reaction) => reaction.id == body.type
      ).icon;
    } else if (childTag === "I") {
      // Crear una nueva imagen
      let newImg = document.createElement("img");
      // Establecer el atributo src de la nueva imagen
      newImg.src = reactions.find((reaction) => reaction.id == body.type).icon;
      // Reemplazar la etiqueta <i> con la nueva imagen
      buttonsAndIcons.replaceChild(newImg, children[0]);
    }
  }
  showReactions(element);
  const reactionResponse = await fetch("s/addReaction/", {
    method: "POST",
    body: JSON.stringify(body),
    headers: { "Content-Type": "application/json" },
  });
  const reactionData = await reactionResponse.json();
};
const addComment = async (body, inputID) => {
  document.querySelectorAll("#add-comment button").forEach((btn) => {
    btn.setAttribute("disabled", true);
  });
  body.content = document.querySelector(inputID).value;
  const commentResponse = await fetch("s/addComment/", {
    method: "POST",
    body: JSON.stringify(body),
    headers: { "Content-Type": "application/json" },
  });
  const reactionData = await commentResponse.json();
  Fancybox.close();
  location.reload();
  document.querySelectorAll("#add-comment button").forEach((btn) => {
    btn.setAttribute("disabled", false);
  });
};
const showReactions = (element) => {
  let postArticle = document.getElementById(element);
  postArticle.querySelector(".reactions-box").classList.toggle("active");
};

const toggleShareMenu = (index) => {
  console.log(index);
  console.log(`share_menu-${index}`);

  const shareMenu = document.getElementById(`share_menu-${index}`);
  if (shareMenu.style.display === "none" || shareMenu.style.display === "") {
    shareMenu.style.display = "flex";
  } else {
    shareMenu.style.display = "none";
  }
};

// Función para copiar el enlace público al portapapeles
const sharePost = (postId) => {
  const publicUrl = `https://bilingualchildcaretraining.com/miembros/sharePost/${postId}`;
  navigator.clipboard
    .writeText(publicUrl)
    .then(() => {
      alert("Enlace copiado al portapapeles");
    })
    .catch((err) => {
      console.error("Error al copiar el enlace: ", err);
    });
};

// Función para compartir en redes sociales
const sharePostToPlatform = (platform, postId) => {
  const publicUrl = `https://bilingualchildcaretraining.com/miembros/sharePost/${postId}`;
  let shareUrl = "";

  switch (platform) {
    case "whatsapp":
      shareUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(
        publicUrl
      )}`;
      break;
    case "facebook":
      shareUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(
        publicUrl
      )}`;
      break;
    case "twitter":
      shareUrl = `https://twitter.com/intent/tweet?url=${encodeURIComponent(
        publicUrl
      )}`;
      break;
    case "linkedin":
      shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(
        publicUrl
      )}`;
      break;
    case "link":
      shareUrl = `https://www.linkedin.com/shareArticle?mini=true&url=${encodeURIComponent(
        publicUrl
      )}`;
      break;
  }

  window.open(shareUrl, "_blank");
};

// Añadir event listeners a los botones de compartir
document.addEventListener("click", (event) => {
  // console.log(event.target);

  // const shareBtn = event.target.closest(".btn_share");
  // if (shareBtn) {
  //   const index = shareBtn.id.split("-")[1];
  //   toggleShareMenu(index);
  // }

  const shareLink = event.target.closest(".share-link");
  if (shareLink) {
    event.preventDefault();
    const platform = shareLink.dataset.platform;
    const postId = shareLink.dataset.postId;
    sharePostToPlatform(platform, postId);
  }
});

const requestposts = async () => {
  if (document.querySelector(".social")) {
    // Evitar solicitudes duplicadas si ya se está realizando una
    if (fetching) return;
    fetching = true; // Marcamos que se está realizando una solicitud

    const container = document.querySelector(".post-list");

    const response = await fetch(`g/getPosts/?page=${page}`);
    const postsData = await response.json();
    // Incrementamos el número de página para la próxima carga
    page++;
    // Verificar si el arreglo de publicaciones está vacío
    if (postsData.length === 0) {
      // Detener la carga de más publicaciones
      document.querySelector(".emptyElement").style.display = "flex";
      fadeOut(preloader);
      return;
    }

    postsData
      .filter((post) => post !== null)
      .forEach((post, index) => {
        let postComments = ``;
        let activeUserReactions = post.reactions.find(
          (reaction) => reaction.acuarelauser == "65d7d5c68cf368c869172f18"
        );
        let templateMedia = ""; // Inicializa templateMedia para cada publicación
        post.media.forEach((singlemedia, index) => {
          let imageUrl;
          if (singlemedia.formats.medium) {
            imageUrl = singlemedia.formats.medium.url;
          } else if (singlemedia.formats.large) {
            imageUrl = singlemedia.formats.large.url;
          } else {
            imageUrl = singlemedia.url;
          }
          templateMedia += `<li class="splide__slide"><img loading="lazy" class="lazyload" data-src="https://acuarelacore.com/api${imageUrl}" alt="imagesPost" src="img/placeholder.png"></li>`;
        });
        let reactionsList = ``;
        reactions.map((reaction) => {
          reactionsList += `<button type="button" onclick="addReaction({post: '${post.id}',type: ${reaction.id},acuarelauser: '65d7d5c68cf368c869172f18'}, '${post.id}')"><img src="${reaction.icon}" alt="happy"><small>${reaction.name}</small></button>`;
        });
        let dialog = `<div id="comments-${post.id
          }" style="display:none;max-width:768px;" class="formcomments"><div class="content_box">
        <div class="comments-list">
            <h3>Comentarios</h3>
            <ul>
            ${post.comments
            .map((comment) => {
              return `<li><img loading="lazy" class="lazyload" data-src="https://acuarelacore.com/api${comment?.acuarelauser?.photo?.url}" alt="imagesPost" src="img/placeholder.png"><div class="comment-info">
              <strong>${comment.acuarelauser.name}</strong>
              <p>${comment.content}</p>
              </div></li>`;
            })
            .join("")}
               
            </ul>
        </div>
        <form id="add-comment">
            <span><input type="text" id="comment-${post.id}" name="comment-${post.id
          }" placeholder="Escribe tu mensaje"></span>
            <button type="button"  onclick="addComment({post: '${post.id
          }'}, '#comment-${post.id
          }')"><svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M13.7347 5.57296L1.95145 0.216402C1.45504 -0.00928566 0.894225 0.0899957 0.487894 0.475371C0.0815634 0.860808 -0.0883852 1.45468 0.0444246 2.02521L1.09324 6.53121H6.22838C6.46468 6.53121 6.65628 6.74109 6.65628 7C6.65628 7.25887 6.4647 7.46878 6.22838 7.46878H1.09324L0.0444246 11.9747C-0.0883852 12.5453 0.0815349 13.1392 0.487894 13.5246C0.895052 13.9107 1.45593 14.0088 1.95148 13.7836L13.7348 8.42703C14.2712 8.18315 14.6045 7.63634 14.6045 7C14.6045 6.36365 14.2712 5.81681 13.7347 5.57296Z" fill="#FBFCFE"/></svg></button>
            </form>
            </div>
            </div>`;
        container.innerHTML += dialog;
        // <button type="button"><i class="acuarela acuarela-Compartir"></i></button>
        let template = `
          <article class="post-list__item" id="${post.id}">
              <div class="post-list__item-header">
                  <img loading="lazy" class="lazyload" data-src="${post.acuarelauser && post.acuarelauser.photo
            ? `https://acuarelacore.com/api${post?.acuarelauser?.photo?.url}`
            : "img/placeholder.png"
          }"
                      alt="UserName" src="img/placeholder.png">
                  <span class="name">${post.acuarelauser && post.acuarelauser.name
          }</span>
              </div>
              <div class="post-list__item-photos">
                  <section class="splide splidePots">
                      <div class="splide__track">
                          <ul class="splide__list">
                          ${templateMedia}
                          </ul>
                      </div>
                  </section>
              </div>
              <div class="post-list__item-footer">
                  <div class="post-list__item-footer-actions">
                      <div class="reactions-actions">
                        <button type="button" onclick="showReactions('${post.id
          }')">
                        ${activeUserReactions
            ? `<img src="${reactions.find(
              (reaction) =>
                reaction.id == activeUserReactions.type
            ).icon
            }" alt="${reactions.find(
              (reaction) =>
                reaction.id == activeUserReactions.type
            ).name
            }">`
            : `<i class="acuarela acuarela-Anadir_reaccion"></i>`
          }
                        </button>
                        <div class="reactions-box">${reactionsList}</div>
                      </div>
                      <button type="button" data-fancybox data-src="#comments-${post.id
          }"><i class="acuarela acuarela-Habla"></i></button>


                      <!--Botón para obtener id de la publicación -->
      <button type="button" class="btn_share" onclick="toggleShareMenu(${index})"><i class="acuarela acuarela-Compartir"></i>
      <div class="share_menu" id="share_menu-${index}" style="display: none;">
                <a href="#" class="share-link" data-platform="whatsapp" data-post-id="${post._id
          }"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-whatsapp" viewBox="0 0 16 16">  <path d="M13.601 2.326A7.85 7.85 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.9 7.9 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.9 7.9 0 0 0 13.6 2.326zM7.994 14.521a6.6 6.6 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.56 6.56 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592m3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.73.73 0 0 0-.529.247c-.182.198-.691.677-.691 1.654s.71 1.916.81 2.049c.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232"/></svg>
          </a>
                <a href="#" class="share-link" data-platform="facebook" data-post-id="${post._id
          }"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">  <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"/></svg>
          </a>
                <a href="#" class="share-link" data-platform="twitter" data-post-id="${post._id
          }"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">  <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/></svg>
          </a>
                <a href="#" class="share-link" data-platform="linkedin" data-post-id="${post._id
          }"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-linkedin" viewBox="0 0 16 16">  <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z"/></svg>
          </a>
          <div onclick="sharePost('${post._id
          }')"><i class="acuarela acuarela-Link"></i></div>
          </div>
          </button>
                      
                  </div>
                  ${post.reactions.length > 0 && post.comments.length > 0
            ? `
                    <div class="post-list__item-footer-counters">
                        <div class="reactions"><img src="" alt="">${post.reactions.length > 0
              ? `${post.reactions.length} ${post.reactions.length === 1
                ? "Rección"
                : "Reacciones"
              }`
              : ""
            }</div>
                        <div class="comments">${post.comments.length > 0
              ? `${post.comments.length} ${post.comments.length === 1
                ? "comentario"
                : "comentarios"
              }`
              : ""
            }</div>
                    </div>
                    `
            : ``
          }
                  <div class="post-list__item-footer-caption">
                      <p><strong>${post.acuarelauser && post.acuarelauser.name
          }</strong><span>${post.classactivity ? post.classactivity.type : ""
          }</span></p>
                      <p>${post.content}</p>
                  </div>
              </div>
          </article>`;
        container.innerHTML += template;
      });

    // Llamar a la función para construir los elementos Splide y las imágenes lazy
    buildSplideAndLazyImages();

    // Llamar a la función fadeOut para desvanecer el preloader
    fadeOut(preloader);
    fetching = false; // Marcamos que la solicitud ha terminado
  }
};
const requestinscripciones = async () => {
  if (document.querySelector(".inscripcionesList")) {
    const container = document.querySelector(
      ".inscripcionesList main .content>ul"
    );
    container.innerHTML = "";

    const response = await fetch(`g/getInscripciones/`);
    const inscripciones = await response.json();
    if (inscripciones.length > 0) {
      inscripciones
        .filter((insc) => insc !== null)
        .forEach((insc, index) => {
          let { name, lastname, status, percentaje, id, child, coppa_status } = insc;

          // Helper para estado COPPA
          const getCoppaBadge = (status) => {
            if (!status || status === 'N/A') return '';

            let colorClass, translateId, textDefault;
            switch (status) {
              case 'granted':
                colorClass = 'success';
                translateId = 198;
                textDefault = 'Aprobado';
                break;
              case 'revoked':
                colorClass = 'danger';
                translateId = 199;
                textDefault = 'Revocado';
                break;
              case 'pending':
              default:
                colorClass = 'warning';
                translateId = 197;
                textDefault = 'Pendiente';
                break;
            }

            return `<div class="coppa-badge ${colorClass}" style="margin-top:5px; font-size: 0.8em;">
                 <strong><span data-translate="200">Estado COPPA</span>:</strong> <span data-translate="${translateId}">${textDefault}</span>
             </div>`;
          };

          const coppaHtml = getCoppaBadge(coppa_status);

          let template = ``;
          if (child) {
            console.log(percentaje);

            template = `<li class="${percentaje >= 100 ? "complete" : ""}">
              <span id="options">
                <i class="acuarela acuarela-Opciones"></i>
                <ul>
                 ${percentaje >= 100
                ? ` <li><a id="profile" href="/miembros/acuarela-app-web/inscripciones/${id}">Editar ninx</a> </li>`
                : ``
              }
                  <li>
                  ${percentaje >= 100
                ? `<a id="profile" href="/miembros/acuarela-app-web/ninxs/${child.id}">Ver perfil</a>`
                : `<a id="profile" href="/miembros/acuarela-app-web/inscripciones/${id}">Editar inscripción</a>`
              }
                    
                  </li>
                  <li>
                    <button type="button" id="deleteinscripcion" onclick='showLightbox("Eliminar Inscripción","¿Estás seguro de que quieres eliminar esta inscripción?","inscripciones","${id}");'>Eliminar</button>
                  </li>
                </ul>
              </span>
              <h3>${name} ${lastname}</h3>
              <small>Estado inscripción: ${status}</small>
              <div class="progress">
                <small><span>Has completado el</span> <strong>${percentaje >= 100 ? 100 : percentaje
              }%</strong></small>
                <div class="bar"><div class="barpro" style="width: ${percentaje}%"></div></div>
              </div>
              ${coppaHtml}
            </li>`;
          } else {
            template = `<li class="${percentaje >= 100 ? "complete" : ""}">
            <span id="options">
              <i class="acuarela acuarela-Opciones"></i>
              <ul>
                <li>
                ${percentaje >= 100
                ? `<a id="profile" href="/miembros/acuarela-app-web/inscripciones/${id}">Editar</a>`
                : `<a id="profile" href="/miembros/acuarela-app-web/inscripciones/${id}">Editar</a>`
              }
                  
                </li>
                <li>
                  <button type="button" id="deleteinscripcion" onclick='showLightbox("Eliminar Inscripción","¿Estás seguro de que quieres eliminar esta inscripción?","inscripciones","${id}");'>Eliminar</button>
                </li>
              </ul>
            </span>
            <h3>${name} ${lastname}</h3>
            <small>Estado inscripción: ${status}</small>
            <div class="progress">
              <small><span>Has completado el</span> <strong>${percentaje >= 100 ? 100 : percentaje
              }%</strong></small>
              <div class="bar"><div class="barpro" style="width: ${percentaje}%"></div></div>
            </div>
          </li>`;
          }
          container.innerHTML += template;

          if (index == inscripciones.length - 1) {
            fadeOut(preloader);
          }
        });
    } else {
      document.querySelector(".emptyElement").style.display = "flex";
    }

    // Actualizar traducciones si la función existe
    if (typeof getTranslateAndReplace === "function") {
      getTranslateAndReplace();
    }
    fadeOut(preloader);
  }
};
// Función para construir los elementos Splide y las imágenes lazy
const buildSplideAndLazyImages = () => {
  document.querySelectorAll(".splidePots").forEach((element) => {
    new Splide(element, {
      navigation: true,
      arrows: false,
    }).mount();
    lazyImages();
    Fancybox.bind("[data-fancybox]", {});
  });
};
const updateKid = async (id, data) => {
  fadeIn(preloader);
  const raw = JSON.stringify({ id, data });
  const requestOptions = {
    method: "POST",
    body: raw,
  };

  fetch("s/updateChildren/", requestOptions)
    .then((response) => response.json())
    .then((result) => {
      getChildren();
    })
    .catch((error) => console.error(error));
};
const sendEmailRegisterCheck = async (
  nameKid,
  nameParent,
  nameDaycare,
  nameAcudiente,
  mail,
  type
) => {
  const url = type === "checkin" ? "s/sendCheckIn/" : "s/sendCheckOut/";

  var myHeaders = new Headers();
  myHeaders.append(
    "token",
    "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJtYWlsIjoib2VqYXJhbWlsbG9AZ21haWwuY29tIiwiaWQiOiI2MmYyNmQwMDVkZTRjY2YwZDA2N2Y1ZGUiLCJuYW1lIjoib3NjIiwicGhvbmUiOiIxMjM0NTY3ODkiLCJpYXQiOjE2NjA4NDA1NzUsImV4cCI6MTY2MTA5OTc3NX0.9q2Q3r7hH_LRYB0D9v1nb2vN_gamNQG5E1_EvDtFocY"
  );

  var formdata = new FormData();
  formdata.append("nameKid", nameKid);
  formdata.append("nameParent", nameParent);
  formdata.append("nameDaycare", nameDaycare);
  formdata.append("nameAcudiente", nameAcudiente);
  formdata.append("time", time);
  formdata.append("date", today);
  formdata.append("mail", mail);
  formdata.append("name", nameParent);

  var requestOptions = {
    method: "POST",
    headers: myHeaders,
    body: formdata,
    redirect: "follow",
  };

  const response = await fetch(url, requestOptions)
    .then((response) => response.json())
    .then((result) => result)
    .catch((error) => console.log("error", error));
  return response;
};

const getChildren = async () => {
  if (document.querySelector(".asistencia")) {
    document
      .querySelectorAll(".activeKid")
      .forEach((el) => el.classList.remove("activeKid"));
    const containerindaycare = document.querySelector(".indaycare");
    const containerinhome = document.querySelector(".inhome");
    const containerinactive = document.querySelector(".inactive");
    containerindaycare.innerHTML = "";
    containerinhome.innerHTML = "";
    containerinactive.innerHTML = "";
    const response = await fetch(`g/getChildren/`);
    const res = await response.json();
    const children = res.response;

    const inDaycare = children.filter(
      (item) => item.indaycare === true && item.status == true
    );
    const notInDaycare = children.filter(
      (item) => item.indaycare === false && item.status == true
    );
    const inactives = children.filter((item) => item.status == false);

    if (inDaycare.length > 0) {
      document.querySelector(".emptyindaycare").style.display = "none";
    } else {
      document.querySelector(".emptyindaycare").style.display = "block";
    }
    if (notInDaycare.length > 0) {
      document.querySelector(".emptyinhome").style.display = "none";
    } else {
      document.querySelector(".emptyinhome").style.display = "block";
    }

    const createKidTemplate = (kid, iconClass) => {
      const isLocked = kid.coppa_status && kid.coppa_status !== 'granted';
      const lockOverlay = isLocked ? `
        <div style="position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.6);z-index:10;display:flex;justify-content:center;align-items:center;border-radius:50%;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#d32f2f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
        </div>` : '';

      return `
    <div class="options">
      <i class="acuarela acuarela-Opciones"></i>
      <ul>
        <li>
          <button type="button" id="desactivar" onclick="updateKid('${kid.id
        }', {'status': false, 'indaycare': false})">Desactivar</button>
        </li>
        <li>
          <button type="button" id="eliminar" onclick='showLightbox("Eliminar Ninx","¿Estás seguro de que quieres eliminar esta ninx?","children","${kid.id
        }");'>Eliminar</button>
        </li>
      </ul>
    </div>
    <div class="image" style="position:relative;">
      ${lockOverlay}
      ${kid.photo
          ? `<img src='https://acuarelacore.com/api/${kid.photo.url}' alt='${kid.name}'>`
          : `
      ${kid.gender === "Masculino" ? `<img src="img/mal.png" alt="">` : ""}
      ${kid.gender === "Femenino" ? `<img src="img/fem.png" alt="">` : ""}
      ${kid.gender === "X" ? `<img src="img/Nonbinary.png" alt="">` : ""}
      `
        }
      ${!isLocked ? `<i class="acuarela ${iconClass}"></i>` : ''}
      <div class="acuarelausers-buttons"></div>
    </div>
    <span class="name">${kid.name}</span>
    <a href="/miembros/acuarela-app-web/ninxs/${kid.id
        }" class="btn btn-action-primary enfasis btn-small">Ver perfil</a>`;
    };

    const createKidInaciveTemplate = (kid, iconClass) => `
        <div class="image">
          ${kid.photo
        ? `<img src='https://acuarelacore.com/api/${kid.photo.url}' alt='${kid.name}'>`
        : `
          ${kid.gender === "Masculino" ? `<img src="img/mal.png" alt="">` : ""}
          ${kid.gender === "Femenino" ? `<img src="img/fem.png" alt="">` : ""}
          ${kid.gender === "X" ? `<img src="img/Nonbinary.png" alt="">` : ""}
          `
      }
        </div>
        <span class="name">${kid.name}</span>
        <button type="button" class="btn btn-action-tertiary enfasis" onclick="updateKid('${kid.id
      }', {'status': true})">Activar</button>`;

    const renderAcuarelaUserButtons = (
      acuarelausers,
      container,
      handleButtonParent
    ) => {
      const widthCircle = 115; // Ancho del contenedor principal
      const radius = widthCircle / 2; // Radio del círculo en el que se posicionan los botones
      const div = 260 / acuarelausers.length;
      let offsetToChildCenter = 38 / 2;
      const offsetToParentCenter = parseInt(widthCircle / 2);
      const totalOffset = offsetToParentCenter - offsetToChildCenter;

      acuarelausers.forEach((acuarelauser, index) => {
        const angleInRadians = div * index * (Math.PI / 180);
        const y = -Math.cos(angleInRadians) * radius + totalOffset;
        const x = Math.sin(angleInRadians) * radius + totalOffset;
        const buttonTemplate = `
       <img loading="lazy" class="lazyload" data-src="${acuarelauser && acuarelauser.photo
            ? `https://acuarelacore.com/api$?{acuarelauser?.photo?.url}`
            : "img/placeholder.png"
          }"
                      alt="UserName" src="img/placeholder.png">
              <span class="acuarelauser-name">${acuarelauser.name}</span>
            `;
        const buttonElement = document.createElement("button");
        buttonElement.classList.add("acuarelauser-button");
        buttonElement.setAttribute("type", "button");
        buttonElement.setAttribute(
          "style",
          `position:absolute;top: ${y}px; left: ${x}px;`
        );
        buttonElement.addEventListener("click", () =>
          handleButtonParent(
            acuarelauser.id,
            acuarelauser.name,
            acuarelauser.mail
          )
        );
        buttonElement.innerHTML = buttonTemplate;

        container.appendChild(buttonElement);
      });
    };

    const renderKids = (kids, container, iconClass, typeCheck) => {
      const fragment = document.createDocumentFragment();

      kids.forEach((kid) => {
        const manualHandle = async (
          parentId,
          parentName,
          parentEmail,
          code
        ) => {
          fadeIn(preloader);

          let data = {};

          // Verificar si el tipo de operación es checkout o no
          if (typeCheck === "checkout") {
            data = {
              children: [kid.id],
              datetime: today,
              acudiente: [parentId],
              code, // Incluir el código si es checkout
            };
          } else {
            data = {
              children: [kid.id],
              datetime: today,
              acudiente: [parentId],
            };
          }

          const raw = JSON.stringify(data);
          const requestOptions = {
            method: "POST",
            body: raw,
          };

          try {
            const response = await fetch(
              `s/setAsistencia/?type=${typeCheck}`,
              requestOptions
            );
            const result = await response.json();

            const infoLightbox = document.getElementById("info-lightbox");
            infoLightbox.style.display = "none";

            // Enviar correo de confirmación (basado en el tipo de registro: check-in o check-out)
            sendEmailRegisterCheck(
              kid.name,
              parentName,
              daycareName,
              parentName,
              parentEmail,
              typeCheck
            );

            // Actualizar la lista de niños
            getChildren();
          } catch (error) {
            console.error("Error en el proceso de registro:", error);
          } finally {
            fadeOut(preloader);
          }
        };
        const template = createKidTemplate(kid, iconClass);
        const listItem = document.createElement("li");
        listItem.innerHTML = template;

        listItem.querySelector(".image").addEventListener("click", () => {
          // COPPA Restriction Check
          const coppaStatus = kid.coppa_status || 'pending';
          if (coppaStatus !== 'granted') {
            let msg = "No se puede registrar asistencia porque el consentimiento COPPA está pendiente de aprobación.";
            if (coppaStatus === 'revoked') msg = "No se puede registrar asistencia porque el consentimiento COPPA ha sido revocado.";

            if (typeof Swal !== 'undefined') {
              Swal.fire({
                title: 'Acción Restringida',
                text: msg,
                icon: 'warning',
                confirmButtonColor: '#0cb5c3'
              });
            } else {
              alert(msg);
            }
            return;
          }

          listItem.classList.toggle("active");
          if (container.querySelectorAll("li.active").length > 0) {
            container.classList.add("activeKid");
          } else {
            container.classList.remove("activeKid");
          }
        });
        fragment.appendChild(listItem);

        // Añadir botones de acuarelausers
        const acuarelaUsersContainer = listItem.querySelector(
          ".acuarelausers-buttons"
        );
        const qrHandle = () => {
          const fragment = document.createDocumentFragment();
          const textContent = document.createElement("p");
          textContent.innerHTML = `El método por QR solo esta disponible en nuestra aplicación.`;
          const extraContent = document.createElement("div");
          extraContent.classList.add("apps");
          extraContent.innerHTML = `<a target="_blank" href="https://play.google.com/store/apps/details?id=com.acuarela.daycaresapp"
            class="btn dashboard"><svg width="131" height="30" viewBox="0 0 131 30" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M0.549585 3.37168C0.282467 3.65622 0.119873 4.10336 0.119873 4.68405V25.3218C0.119873 25.9025 0.282467 26.3439 0.549585 26.6342L0.619268 26.7039L12.1808 15.1365V14.9971V14.8636L0.619268 3.302L0.549585 3.37168Z"
                    fill="#5BC9F4"></path>
                <path
                    d="M16.0366 18.9923L12.1808 15.1365V14.9972V14.8636L16.0366 11.0078L16.1237 11.0601L20.6879 13.6558C21.9945 14.3991 21.9945 15.6069 20.6879 16.3502L16.1237 18.9459L16.0366 18.9923Z"
                    fill="url(#paint0_linear)"></path>
                <path
                    d="M16.1237 18.9458L12.1808 15.0029L0.549561 26.6342C0.979273 27.0871 1.68772 27.1452 2.48907 26.6923L16.1237 18.9458Z"
                    fill="url(#paint1_linear)"></path>
                <path
                    d="M16.1237 11.06L2.48907 3.31361C1.68772 2.86067 0.979273 2.91293 0.549561 3.37168L12.1808 15.0029L16.1237 11.06Z"
                    fill="url(#paint2_linear)"></path>
                <path
                    d="M67.4612 16.2904C64.8772 16.2904 62.7648 18.2593 62.7648 20.9664C62.7648 23.6598 64.8703 25.6423 67.4612 25.6423C70.0453 25.6423 72.1577 23.6598 72.1577 20.9664C72.1508 18.2593 70.0453 16.2904 67.4612 16.2904ZM67.4612 23.8034C66.0462 23.8034 64.8225 22.6344 64.8225 20.9664C64.8225 19.2847 66.0462 18.1294 67.4612 18.1294C68.8763 18.1294 70.1 19.2778 70.1 20.9664C70.1 22.6344 68.8763 23.8034 67.4612 23.8034ZM57.2207 16.2904C54.6366 16.2904 52.5243 18.2593 52.5243 20.9664C52.5243 23.6598 54.6298 25.6423 57.2207 25.6423C59.8048 25.6423 61.9171 23.6598 61.9171 20.9664C61.9103 18.2593 59.8048 16.2904 57.2207 16.2904ZM57.2207 23.8034C55.8056 23.8034 54.5819 22.6344 54.5819 20.9664C54.5819 19.2847 55.8056 18.1294 57.2207 18.1294C58.6358 18.1294 59.8594 19.2778 59.8594 20.9664C59.8594 22.6344 58.6358 23.8034 57.2207 23.8034ZM45.0387 17.726V19.7085H49.783C49.6394 20.8228 49.2703 21.6363 48.7029 22.2037C48.0124 22.8942 46.9323 23.653 45.0387 23.653C42.1128 23.653 39.8295 21.2945 39.8295 18.3755C39.8295 15.4564 42.1128 13.098 45.0387 13.098C46.6178 13.098 47.7663 13.7201 48.614 14.513L50.0154 13.1116C48.8259 11.9768 47.2536 11.1086 45.0387 11.1086C41.0327 11.1155 37.6693 14.3763 37.6693 18.3823C37.6693 22.3883 41.0327 25.6423 45.0387 25.6423C47.1989 25.6423 48.8327 24.9313 50.1043 23.6051C51.4168 22.2926 51.8201 20.4537 51.8201 18.9634C51.8201 18.5054 51.786 18.0747 51.7108 17.726H45.0387V17.726ZM94.8537 19.2642C94.464 18.2182 93.2745 16.2904 90.8477 16.2904C88.4414 16.2904 86.4384 18.1841 86.4384 20.9664C86.4384 23.5914 88.4209 25.6423 91.0801 25.6423C93.2267 25.6423 94.464 24.3297 94.9767 23.5709L93.3839 22.5113C92.8507 23.2907 92.126 23.8034 91.0801 23.8034C90.0342 23.8034 89.289 23.3248 88.8105 22.3883L95.0656 19.8042L94.8537 19.2642ZM88.4755 20.8228C88.4209 19.0181 89.877 18.0952 90.9229 18.0952C91.7364 18.0952 92.4268 18.5054 92.6593 19.0864L88.4755 20.8228ZM83.3963 25.362H85.454V11.6145H83.3963V25.362ZM80.0261 17.3364H79.9577C79.4997 16.7895 78.611 16.2904 77.4967 16.2904C75.1587 16.2904 73.0122 18.3481 73.0122 20.9869C73.0122 23.6051 75.1587 25.6423 77.4967 25.6423C78.611 25.6423 79.4997 25.1432 79.9577 24.5827H80.0261V25.2526C80.0261 27.0437 79.069 28.0008 77.5309 28.0008C76.273 28.0008 75.4937 27.0984 75.1724 26.3327L73.3813 27.0779C73.8941 28.3152 75.2613 29.8397 77.524 29.8397C79.9304 29.8397 81.9675 28.4246 81.9675 24.9655V16.5707H80.0192V17.3364H80.0261ZM77.6744 23.8034C76.2594 23.8034 75.0699 22.6139 75.0699 20.9869C75.0699 19.3394 76.2594 18.1362 77.6744 18.1362C79.0758 18.1362 80.1696 19.3394 80.1696 20.9869C80.1696 22.6139 79.069 23.8034 77.6744 23.8034ZM104.479 11.6145H99.5638V25.362H101.615V20.1529H104.479C106.755 20.1529 108.991 18.5054 108.991 15.8871C108.991 13.2689 106.755 11.6145 104.479 11.6145ZM104.534 18.2387H101.615V13.5286H104.534C106.065 13.5286 106.94 14.8002 106.94 15.8871C106.94 16.9467 106.065 18.2387 104.534 18.2387ZM117.215 16.2631C115.731 16.2631 114.193 16.9194 113.557 18.3686L115.376 19.1274C115.765 18.3686 116.49 18.1225 117.249 18.1225C118.308 18.1225 119.389 18.7583 119.409 19.8931V20.0366C119.04 19.8247 118.24 19.5034 117.269 19.5034C115.307 19.5034 113.311 20.5835 113.311 22.6002C113.311 24.4391 114.918 25.6218 116.723 25.6218C118.103 25.6218 118.862 24.9997 119.341 24.2751H119.409V25.3347H121.392V20.064C121.385 17.6303 119.566 16.2631 117.215 16.2631ZM116.962 23.7965C116.292 23.7965 115.355 23.4616 115.355 22.6275C115.355 21.5679 116.524 21.1578 117.529 21.1578C118.432 21.1578 118.855 21.3492 119.402 21.6158C119.245 22.8942 118.151 23.7965 116.962 23.7965ZM128.604 16.5639L126.252 22.525H126.184L123.743 16.5639H121.535L125.192 24.8903L123.107 29.5252H125.247L130.887 16.5639H128.604V16.5639ZM110.119 25.362H112.17V11.6145H110.119V25.362Z"
                    fill="currentColor"></path>
                <path
                    d="M38.1273 6.57637V0.0888672H39.9594C40.5268 0.0888672 41.0258 0.211918 41.4565 0.464855C41.8872 0.710957 42.2222 1.06644 42.4614 1.53129C42.7007 1.98932 42.8169 2.52254 42.8169 3.11728V3.53429C42.8169 4.14954 42.7007 4.68276 42.4614 5.14078C42.229 5.5988 41.894 5.95428 41.4497 6.20038C41.0122 6.44648 40.5063 6.56953 39.9252 6.57637H38.1273ZM38.9818 0.786154V5.87908H39.8842C40.5405 5.87908 41.06 5.674 41.4223 5.26383C41.7915 4.85366 41.9761 4.27259 41.9761 3.51378V3.13095C41.9761 2.39265 41.8052 1.81841 41.4565 1.40824C41.1079 0.998075 40.6225 0.79299 39.9868 0.786154H38.9818Z"
                    fill="currentColor"></path>
                <path d="M44.9771 6.57637H44.1226V0.0888672H44.9771V6.57637Z" fill="currentColor"></path>
                <path
                    d="M48.4431 3.68468C47.7116 3.47276 47.1784 3.21299 46.8434 2.90536C46.5084 2.59774 46.3444 2.22175 46.3444 1.76373C46.3444 1.25101 46.5495 0.827174 46.9596 0.499039C47.363 0.164068 47.8893 0 48.5456 0C48.99 0 49.3865 0.0888699 49.7351 0.259774C50.0837 0.430677 50.3572 0.669942 50.5486 0.970733C50.74 1.27152 50.8357 1.60649 50.8357 1.96197H49.9744C49.9744 1.56548 49.8513 1.25785 49.5984 1.03226C49.3523 0.806665 48.9968 0.697287 48.5456 0.697287C48.1218 0.697287 47.7936 0.792993 47.5612 0.977569C47.3219 1.16214 47.2057 1.42192 47.2057 1.75005C47.2057 2.01666 47.3151 2.23542 47.5407 2.42C47.7663 2.60457 48.1491 2.76864 48.6892 2.91903C49.2292 3.06943 49.6531 3.24033 49.9539 3.41807C50.2615 3.60265 50.4871 3.81457 50.6306 4.06067C50.781 4.30677 50.8494 4.59389 50.8494 4.92203C50.8494 5.44841 50.6443 5.87225 50.2341 6.18671C49.824 6.50118 49.2771 6.65841 48.5866 6.65841C48.1423 6.65841 47.7253 6.57637 47.3356 6.39863C46.9528 6.22773 46.652 5.9953 46.4401 5.69451C46.2282 5.40056 46.1256 5.05875 46.1256 4.68276H46.987C46.987 5.07242 47.1305 5.38688 47.4245 5.61248C47.7184 5.83807 48.1013 5.95428 48.5866 5.95428C49.0378 5.95428 49.3865 5.86541 49.6257 5.68084C49.865 5.49626 49.988 5.24332 49.988 4.92886C49.988 4.6144 49.8787 4.3683 49.6531 4.19056C49.4343 4.02649 49.031 3.85559 48.4431 3.68468Z"
                    fill="currentColor"></path>
                <path
                    d="M52.8865 4.04016V6.58321H52.0251V0.0888672H54.4178C55.1288 0.0888672 55.6825 0.273443 56.0858 0.635759C56.4891 0.998075 56.6874 1.4766 56.6874 2.07819C56.6874 2.70711 56.4891 3.19248 56.0995 3.53429C55.703 3.87609 55.1424 4.047 54.411 4.047H52.8865V4.04016ZM52.8865 3.33604H54.4246C54.8827 3.33604 55.2313 3.22666 55.4774 3.01474C55.7235 2.79598 55.8397 2.48835 55.8397 2.07819C55.8397 1.68853 55.7167 1.3809 55.4774 1.14847C55.2313 0.916041 54.8963 0.79299 54.4725 0.786154H52.8865V3.33604Z"
                    fill="currentColor"></path>
                <path
                    d="M62.84 3.54112C62.84 4.17689 62.7306 4.73061 62.5187 5.20231C62.3068 5.674 61.9992 6.03632 61.6095 6.28925C61.2198 6.53536 60.7618 6.66524 60.2354 6.66524C59.7227 6.66524 59.2715 6.54219 58.875 6.28925C58.4785 6.03632 58.1709 5.68084 57.9522 5.21598C57.7334 4.75112 57.624 4.21107 57.6172 3.60265V3.13095C57.6172 2.50887 57.7266 1.95514 57.9453 1.47661C58.1641 0.998077 58.4717 0.628925 58.8682 0.375988C59.2647 0.129887 59.7159 0 60.2286 0C60.7481 0 61.2062 0.123051 61.6027 0.375988C61.9992 0.628925 62.3068 0.991241 62.5187 1.46977C62.7306 1.9483 62.84 2.50203 62.84 3.13095V3.54112ZM61.9855 3.12412C61.9855 2.35163 61.8283 1.76373 61.5206 1.35356C61.213 0.943388 60.7823 0.738304 60.2218 0.738304C59.6817 0.738304 59.2579 0.943388 58.9434 1.35356C58.6358 1.76373 58.4717 2.33796 58.4649 3.06943V3.54796C58.4649 4.2931 58.6221 4.88101 58.9366 5.30485C59.251 5.72869 59.6817 5.94745 60.2286 5.94745C60.7823 5.94745 61.2062 5.7492 61.5138 5.34587C61.8146 4.94253 61.9718 4.3683 61.9787 3.61632V3.12412H61.9855Z"
                    fill="currentColor"></path>
                <path
                    d="M69.1155 6.57637H68.2542L64.9865 1.57915V6.57637H64.1251V0.0888672H64.9865L68.261 5.11343V0.0888672H69.1155V6.57637Z"
                    fill="currentColor"></path>
                <path d="M71.5219 6.57637H70.6674V0.0888672H71.5219V6.57637Z" fill="currentColor"></path>
                <path
                    d="M73.0669 6.57637V0.0888672H75.1861C75.8902 0.0888672 76.4166 0.232426 76.7721 0.526381C77.1276 0.820335 77.3053 1.25101 77.3053 1.81841C77.3053 2.1192 77.2164 2.39265 77.0455 2.62508C76.8746 2.85751 76.6422 3.03525 76.3414 3.16513C76.6901 3.26084 76.9703 3.45225 77.1754 3.7257C77.3805 3.99914 77.483 4.32728 77.483 4.7101C77.483 5.29117 77.2916 5.7492 76.9156 6.08417C76.5397 6.41914 76.0064 6.58321 75.316 6.58321H73.0669V6.57637ZM73.9214 2.85751H75.2134C75.5894 2.85751 75.8902 2.7618 76.109 2.57722C76.3277 2.39265 76.444 2.13288 76.444 1.81158C76.444 1.4561 76.3414 1.19632 76.1295 1.03226C75.9244 0.868188 75.6031 0.786154 75.1793 0.786154H73.9146V2.85751H73.9214ZM73.9214 3.54112V5.87908H75.3365C75.733 5.87908 76.0475 5.77654 76.2799 5.57146C76.5123 5.36637 76.6217 5.07925 76.6217 4.71694C76.6217 3.93762 76.1979 3.54796 75.3502 3.54796H73.9214V3.54112Z"
                    fill="currentColor"></path>
                <path d="M79.609 5.87908H82.6853V6.57637H78.7477V0.0888672H79.609V5.87908V5.87908Z" fill="currentColor">
                </path>
                <path
                    d="M87.3612 3.5753H84.5515V5.87908H87.8192V6.57637H83.697V0.0888672H87.7714V0.786154H84.5515V2.87801H87.3612V3.5753Z"
                    fill="currentColor"></path>
                <path
                    d="M94.8058 3.5753H91.9961V5.87908H95.2638V6.57637H91.1416V0.0888672H95.2159V0.786154H91.9961V2.87801H94.8058V3.5753Z"
                    fill="currentColor"></path>
                <path
                    d="M101.3 6.57637H100.439L97.1712 1.57915V6.57637H96.3098V0.0888672H97.1712L100.446 5.11343V0.0888672H101.3V6.57637Z"
                    fill="currentColor"></path>
                <defs>
                    <linearGradient id="paint0_linear" x1="19.8417" y1="15.0018" x2="-2.73881" y2="15.0018"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#FEE000"></stop>
                        <stop offset="0.1941" stop-color="#FCCF0B"></stop>
                        <stop offset="0.5469" stop-color="#FAB318"></stop>
                        <stop offset="0.8279" stop-color="#F9A21B"></stop>
                        <stop offset="1" stop-color="#F99B1C"></stop>
                    </linearGradient>
                    <linearGradient id="paint1_linear" x1="13.9818" y1="17.1431" x2="-7.25617" y2="38.3811"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#EF4547"></stop>
                        <stop offset="1" stop-color="#C6186D"></stop>
                    </linearGradient>
                    <linearGradient id="paint2_linear" x1="-7.35081" y1="-8.4731" x2="9.98946" y2="8.86717"
                        gradientUnits="userSpaceOnUse">
                        <stop stop-color="#279E6F"></stop>
                        <stop offset="0.3168" stop-color="#4DAB6D"></stop>
                        <stop offset="0.7398" stop-color="#6ABA6A"></stop>
                        <stop offset="1" stop-color="#74C169"></stop>
                    </linearGradient>
                </defs>
            </svg>
        </a>
        <a target="_blank" href="https://apps.apple.com/us/app/acuarela-for-daycares/id1573321954"
            class="btn dashboard"><svg width="125" height="33" viewBox="0 0 125 33" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M17.1387 16.7628C17.1096 13.7294 19.6191 12.2563 19.7355 12.1864C18.3149 10.1136 16.1082 9.82833 15.3338 9.80504C13.4823 9.6129 11.6889 10.9113 10.7457 10.9113C9.78502 10.9113 8.32941 9.82251 6.76901 9.85162C4.75445 9.88656 2.87381 11.051 1.83742 12.856C-0.293584 16.5474 1.29594 21.9681 3.3396 24.955C4.36435 26.4164 5.55794 28.0467 7.11835 27.9884C8.64383 27.9244 9.21442 27.0161 11.0601 27.0161C12.8884 27.0161 13.424 27.9884 15.0194 27.9535C16.6613 27.9244 17.6919 26.4863 18.6758 25.0132C19.8578 23.3363 20.3294 21.6886 20.3527 21.6071C20.3178 21.6013 17.1678 20.396 17.1387 16.7628Z"
                    fill="currentColor"></path>
                <path
                    d="M14.1285 7.84862C14.9495 6.81805 15.5143 5.42067 15.3571 4C14.1693 4.0524 12.6788 4.82096 11.8229 5.82824C11.0659 6.71325 10.3847 8.16885 10.5594 9.5313C11.8986 9.63028 13.2668 8.85589 14.1285 7.84862Z"
                    fill="currentColor"></path>
                <path
                    d="M41.0696 13.0435L36.3527 27.7002H38.7863L40.092 23.3934H44.85L46.2172 27.7002H48.7192L43.9818 13.0435H41.0696V13.0435ZM40.5022 21.5886L41.719 17.7604C42.0403 16.5436 42.2728 15.6275 42.4163 14.9986H42.4573C42.8197 16.4479 43.0658 17.3707 43.1956 17.7604L44.433 21.5886H40.5022Z"
                    fill="currentColor"></path>
                <path
                    d="M56.4851 16.9126C54.8923 16.9126 53.7028 17.5415 52.9235 18.8062H52.8756L52.7457 17.1314H50.6812C50.7359 18.3208 50.7701 19.483 50.7701 20.611V32.0068H53.1217V26.4422H53.1627C53.7712 27.4403 54.7692 27.9393 56.1638 27.9393C57.449 27.9393 58.5291 27.4744 59.4041 26.5516C60.3749 25.5056 60.8602 24.0837 60.8602 22.2926C60.8602 20.6862 60.4432 19.3873 59.6092 18.4029C58.7752 17.4048 57.7293 16.9126 56.4851 16.9126ZM57.7224 25.0681C57.2302 25.7517 56.5398 26.0867 55.6579 26.0867C54.906 26.0867 54.2907 25.8269 53.819 25.2937C53.3473 24.7673 53.1149 24.1179 53.1149 23.3454V21.5817C53.1149 21.3971 53.1491 21.1578 53.2243 20.8639C53.3678 20.2418 53.6754 19.7359 54.1471 19.3531C54.612 18.9703 55.1452 18.7789 55.7263 18.7789C56.5808 18.7789 57.2644 19.1275 57.7703 19.8248C58.2352 20.4947 58.4676 21.3424 58.4676 22.3678C58.4676 23.489 58.2215 24.3845 57.7224 25.0681Z"
                    fill="currentColor"></path>
                <path
                    d="M68.6398 16.9126C67.0401 16.9126 65.8575 17.5415 65.0781 18.8062H65.0303L64.9004 17.1314H62.8359C62.8906 18.3208 62.9248 19.483 62.9248 20.611V32.0068H65.2696V26.4422H65.3106C65.919 27.4403 66.9171 27.9393 68.3116 27.9393C69.6037 27.9393 70.6838 27.4744 71.552 26.5516C72.5227 25.5056 73.0081 24.0837 73.0081 22.2926C73.0081 20.6862 72.5911 19.3873 71.7571 18.4029C70.9299 17.4048 69.884 16.9126 68.6398 16.9126ZM69.8771 25.0681C69.3849 25.7517 68.6945 26.0867 67.8126 26.0867C67.0538 26.0867 66.4454 25.8269 65.9737 25.2937C65.502 24.7673 65.2696 24.1179 65.2696 23.3454V21.5817C65.2696 21.3971 65.3037 21.1578 65.3789 20.8639C65.5225 20.2418 65.8301 19.7359 66.3018 19.3531C66.7735 18.9703 67.2999 18.7789 67.881 18.7789C68.7355 18.7789 69.4191 19.1275 69.925 19.8248C70.3898 20.4947 70.6223 21.3424 70.6223 22.3678C70.6223 23.489 70.3693 24.3845 69.8771 25.0681Z"
                    fill="currentColor"></path>
                <path
                    d="M82.9273 19.2644C81.8951 18.8542 81.1841 18.4782 80.7944 18.1296C80.3433 17.7536 80.1245 17.275 80.1245 16.694C80.1245 16.1744 80.3227 15.7301 80.7124 15.3678C81.1773 14.9644 81.8199 14.7593 82.647 14.7593C83.693 14.7593 84.6295 14.9849 85.4499 15.4361L86.0378 13.522C85.1559 13.0571 84.0484 12.8247 82.7154 12.8247C81.2183 12.8247 80.022 13.2075 79.1264 13.98C78.2241 14.7457 77.7797 15.7369 77.7797 16.9401C77.7797 18.7858 79.0581 20.1872 81.6285 21.1443C82.5718 21.4929 83.2486 21.8689 83.652 22.2791C84.0553 22.6824 84.2604 23.1883 84.2604 23.7831C84.2604 24.453 84.0143 24.9862 83.5221 25.3827C83.023 25.7792 82.3326 25.9775 81.4439 25.9775C80.2134 25.9775 79.0786 25.6698 78.0463 25.0409L77.4994 26.996C78.4565 27.6045 79.7212 27.9052 81.3003 27.9052C83.0094 27.9052 84.3356 27.4814 85.2926 26.6201C86.1608 25.8339 86.5983 24.8221 86.5983 23.578C86.5983 22.5662 86.2975 21.7185 85.7096 21.0349C85.1149 20.365 84.1852 19.7702 82.9273 19.2644Z"
                    fill="currentColor"></path>
                <path
                    d="M91.7733 14.4995L89.4695 15.1968V17.1314H87.9245V18.8952H89.4695V24.2205C89.4695 25.5536 89.7293 26.5038 90.2557 27.0712C90.7752 27.6386 91.4998 27.9189 92.4296 27.9189C93.1815 27.9189 93.7968 27.83 94.2548 27.6591L94.1933 25.8749C93.9198 25.9432 93.5712 25.9842 93.1542 25.9842C92.2381 25.9842 91.7801 25.3348 91.7801 24.0291V18.8952H94.3642V17.1314H91.7801V14.4995H91.7733Z"
                    fill="currentColor"></path>
                <path
                    d="M100.947 16.9126C99.3409 16.9126 98.0557 17.4321 97.1123 18.4781C96.1621 19.5172 95.6904 20.8639 95.6904 22.4977C95.6904 24.0632 96.1484 25.3621 97.0713 26.3875C97.9942 27.4198 99.2247 27.9325 100.777 27.9325C102.383 27.9325 103.675 27.3992 104.646 26.326C105.575 25.28 106.033 23.947 106.033 22.3268C106.033 20.7477 105.582 19.4556 104.687 18.4576C103.75 17.4253 102.499 16.9126 100.947 16.9126ZM102.95 24.9314C102.445 25.7928 101.74 26.2166 100.845 26.2166C99.9288 26.2166 99.2179 25.7928 98.712 24.9519C98.2881 24.2546 98.0831 23.4206 98.0831 22.443C98.0831 21.4381 98.2881 20.5904 98.712 19.8932C99.2042 19.0523 99.922 18.6285 100.865 18.6285C101.775 18.6285 102.479 19.0523 102.971 19.8932C103.395 20.5904 103.6 21.4245 103.6 22.402C103.6 23.3796 103.388 24.2204 102.95 24.9314Z"
                    fill="currentColor"></path>
                <path
                    d="M111.386 17.48C110.853 17.897 110.456 18.4576 110.21 19.1549H110.149L110.06 17.1314H108.016C108.071 18.1294 108.105 19.2437 108.105 20.4606L108.084 27.7H110.429V22.1559C110.429 21.3151 110.627 20.6178 111.017 20.0709C111.468 19.4488 112.111 19.1343 112.931 19.1343C113.191 19.1343 113.437 19.1549 113.669 19.1959V16.9536C113.499 16.9263 113.3 16.9126 113.082 16.9126C112.473 16.9126 111.906 17.104 111.386 17.48Z"
                    fill="currentColor"></path>
                <path
                    d="M124.17 21.9167C124.17 20.5973 123.862 19.4898 123.24 18.5875C122.454 17.4595 121.299 16.8921 119.781 16.8921C118.229 16.8921 116.999 17.4595 116.089 18.5875C115.221 19.6471 114.784 20.9733 114.784 22.5661C114.784 24.1863 115.255 25.4851 116.185 26.449C117.122 27.4129 118.407 27.8983 120.041 27.8983C121.408 27.8983 122.584 27.6795 123.589 27.242L123.22 25.6082C122.365 25.9431 121.415 26.1072 120.369 26.1072C119.426 26.1072 118.653 25.8611 118.065 25.3689C117.416 24.8152 117.074 24.0222 117.047 22.9763H124.088C124.142 22.6891 124.17 22.3337 124.17 21.9167ZM117.04 21.3014C117.108 20.5904 117.34 19.982 117.73 19.4762C118.209 18.8404 118.831 18.5191 119.596 18.5191C120.437 18.5191 121.059 18.8472 121.47 19.4967C121.791 20.0025 121.941 20.6041 121.928 21.3014H117.04V21.3014Z"
                    fill="currentColor"></path>
                <path
                    d="M43.1478 4.14952C43.1478 1.83891 42.1018 0.526367 39.8869 0.526367H37.2277V7.8137H39.8869C42.0882 7.8137 43.1478 6.46698 43.1478 4.14952ZM38.6701 6.63105V1.70218H39.6955C41.138 1.70218 41.6643 2.66608 41.6643 4.17687C41.6643 6.02263 40.9124 6.63105 39.6955 6.63105H38.6701Z"
                    fill="currentColor"></path>
                <path d="M45.7934 2.14648H44.392V7.81365H45.7934V2.14648Z" fill="currentColor"></path>
                <path
                    d="M45.0893 1.47661C45.5268 1.47661 45.8823 1.17582 45.8823 0.738304C45.8823 0.30079 45.5268 0 45.0893 0C44.6586 0 44.2963 0.307627 44.2963 0.74514C44.2963 1.18265 44.6586 1.47661 45.0893 1.47661Z"
                    fill="currentColor"></path>
                <path
                    d="M51.734 6.0636C51.734 5.01767 50.9684 4.66219 49.9293 4.47078C49.2798 4.35456 48.4663 4.25886 48.4663 3.69829C48.4663 3.28129 48.8218 3.02835 49.3687 3.02835C50.0523 3.02835 50.2847 3.42485 50.3189 3.78033H51.5631C51.5631 2.72756 50.7428 2.05078 49.396 2.05078C48.2065 2.05078 47.1264 2.57716 47.1264 3.83502C47.1264 4.88095 47.9468 5.26377 48.9722 5.47569C49.6968 5.61925 50.3736 5.70128 50.3736 6.24818C50.3736 6.61733 50.066 6.93179 49.4029 6.93179C48.8013 6.93179 48.439 6.64467 48.3775 6.22767H47.0171C47.0171 7.23942 47.8647 7.92303 49.3277 7.92303C50.818 7.91619 51.734 7.22574 51.734 6.0636Z"
                    fill="currentColor"></path>
                <path
                    d="M54.3727 6.99331H54.4343C54.7145 7.52653 55.2751 7.88201 56.0271 7.88201C57.3123 7.88201 58.1873 6.91812 58.1873 5.20908V4.73055C58.1873 3.01468 57.3123 2.07129 56.0544 2.07129C55.2819 2.07129 54.7009 2.44044 54.4138 2.98733H54.3522V2.14649H52.9645V9.69359H54.3727V6.99331ZM54.3659 4.77157C54.3659 3.78716 54.8444 3.19242 55.5759 3.19242C56.3005 3.19242 56.7449 3.75982 56.7449 4.7784V5.15439C56.7449 6.21399 56.2732 6.76772 55.5896 6.76772C54.8444 6.76772 54.3591 6.1593 54.3591 5.15439V4.77157H54.3659Z"
                    fill="currentColor"></path>
                <path
                    d="M64.4287 5.16806V4.75106C64.4287 3.18558 63.5058 2.04395 61.8378 2.04395C60.163 2.04395 59.2401 3.19242 59.2401 4.75789V5.1749C59.2401 6.82241 60.163 7.91619 61.8378 7.91619C63.5127 7.91619 64.4287 6.82241 64.4287 5.16806ZM63.0068 5.18857C63.0068 6.08411 62.6513 6.81557 61.8378 6.81557C61.0175 6.81557 60.662 6.07727 60.662 5.18857V4.75106C60.662 3.83502 61.0243 3.13089 61.8378 3.13089C62.6513 3.13089 63.0068 3.82818 63.0068 4.75106V5.18857Z"
                    fill="currentColor"></path>
                <path
                    d="M67.1085 4.49129C67.1085 3.77349 67.505 3.25394 68.2296 3.25394C68.8312 3.25394 69.3371 3.60259 69.3371 4.47078V7.81365H70.7453V4.16315C70.7453 2.77541 69.9386 2.05078 68.7833 2.05078C67.8399 2.05078 67.3204 2.57716 67.1358 2.96682H67.0743V2.14649H65.7071V7.81365H67.1085V4.49129V4.49129Z"
                    fill="currentColor"></path>
                <path
                    d="M72.9124 0C72.4817 0 72.1194 0.307627 72.1194 0.74514C72.1194 1.18265 72.4817 1.48344 72.9124 1.48344C73.3499 1.48344 73.7054 1.18265 73.7054 0.74514C73.7054 0.307627 73.3499 0 72.9124 0Z"
                    fill="currentColor"></path>
                <path d="M73.6097 2.14648H72.2082V7.81365H73.6097V2.14648Z" fill="currentColor"></path>
                <path
                    d="M80.4184 5.22281V4.72377C80.4184 2.99423 79.5503 2.07135 78.2582 2.07135C77.5131 2.07135 76.8773 2.4405 76.6312 2.96688H76.5697V0.136719H75.1615V7.81371H76.5492V6.93868H76.6039C76.8842 7.51976 77.4516 7.88891 78.2514 7.88891C79.5639 7.88891 80.4184 6.91818 80.4184 5.22281ZM76.5629 5.16812V4.7853C76.5629 3.73937 77.0551 3.19931 77.8139 3.19931C78.5043 3.19931 78.976 3.7462 78.976 4.7853V5.17496C78.976 6.21405 78.4975 6.76778 77.8139 6.76778C77.0482 6.76778 76.5629 6.21405 76.5629 5.16812Z"
                    fill="currentColor"></path>
                <path d="M83.1529 0.136719H81.7447V7.81371H83.1529V0.136719Z" fill="currentColor"></path>
                <path
                    d="M89.4217 6.10462H88.116C87.9998 6.56264 87.6033 6.84292 87.0427 6.84292C86.3249 6.84292 85.8395 6.29603 85.8395 5.44151V5.28428H89.4695V4.72371C89.4695 3.09671 88.5125 2.04395 86.9675 2.04395C85.4772 2.04395 84.4586 3.02835 84.4586 4.68953V5.20908C84.4586 6.94546 85.4704 7.91619 87.029 7.91619C88.5535 7.91619 89.2918 7.01382 89.4217 6.10462ZM85.8464 4.38191C85.8464 3.65728 86.2975 3.09671 86.988 3.09671C87.6716 3.09671 88.116 3.65044 88.116 4.38191V4.39558H85.8464V4.38191Z"
                    fill="currentColor"></path>
                <path
                    d="M97.7276 6.10462H96.4219C96.3057 6.56264 95.9092 6.84292 95.3486 6.84292C94.6308 6.84292 94.1454 6.29603 94.1454 5.44151V5.28428H97.7754V4.72371C97.7754 3.09671 96.8184 2.04395 95.2734 2.04395C93.7831 2.04395 92.7645 3.02835 92.7645 4.68953V5.20908C92.7645 6.94546 93.7763 7.91619 95.3349 7.91619C96.8594 7.91619 97.5977 7.01382 97.7276 6.10462ZM94.1523 4.38191C94.1523 3.65728 94.6035 3.09671 95.2939 3.09671C95.9775 3.09671 96.4219 3.65044 96.4219 4.38191V4.39558H94.1523V4.38191V4.38191Z"
                    fill="currentColor"></path>
                <path
                    d="M100.455 4.49129C100.455 3.77349 100.852 3.25394 101.576 3.25394C102.178 3.25394 102.684 3.60259 102.684 4.47078V7.81365H104.085V4.16315C104.085 2.77541 103.279 2.05078 102.123 2.05078C101.18 2.05078 100.66 2.57716 100.476 2.96682H100.414V2.14649H99.047V7.81365H100.448V4.49129H100.455Z"
                    fill="currentColor"></path>
            </svg>
        </a>`;
          fragment.appendChild(textContent);
          fragment.appendChild(extraContent);
          showInfoLightbox("Método por QR no disponible", fragment);
        };

        const resetDialogStates = () => {
          const dialogCode = document.getElementById("dialog-code");
          const exitoCodigo = document.getElementById("exitoCodigo");
          const errorCodigo = document.getElementById("errorCodigo");
          const dialogContainer = document.querySelector(".dialog-container");

          dialogCode.style.display = "flex";
          exitoCodigo.style.display = "none";
          errorCodigo.style.display = "none";

          dialogContainer.close();
        };

        const validateAndProcessCheckout = async (
          parentId,
          parentName,
          parentEmail,
          codeInput
        ) => {
          fadeIn(preloader);

          try {
            const response = await fetch(
              `https://app.acuarelaschool.com.co/wp-json/ac/v1/getCodeAcudiente?codigo=${codeInput}`
            );
            const data = await response.json();

            if (data && data[0] && data[0].id === parentId) {
              // El código es correcto, registrar la salida
              await processCheckout(
                parentId,
                parentName,
                parentEmail,
                codeInput
              );
            } else {
              // El código no es correcto
              alert("Código incorrecto, por favor intenta nuevamente.");
            }
          } catch (error) {
            console.error("Error validando el código:", error);
          } finally {
            fadeOut(preloader);
          }
        };

        // Función para procesar el registro de salida
        const processCheckout = async (
          parentId,
          parentName,
          parentEmail,
          code
        ) => {
          let data = {
            children: [kid.id],
            datetime: today,
            acudiente: [parentId],
            code, // Incluye el código si es necesario para el backend
          };

          const raw = JSON.stringify(data);
          const requestOptions = {
            method: "POST",
            body: raw,
          };

          try {
            const response = await fetch(
              `s/setAsistencia/?type=checkout`,
              requestOptions
            );
            const result = await response.json();

            const infoLightbox = document.getElementById("info-lightbox");
            infoLightbox.style.display = "none";

            // Enviar correo de confirmación
            sendEmailRegisterCheck(
              kid.name,
              parentName,
              foundDaycare.name,
              parentName,
              parentEmail,
              "checkout"
            );

            // Actualizar la lista de niños
            getChildren();
          } catch (error) {
            console.error("Error registrando la salida:", error);
          } finally {
            fadeOut(preloader);
          }
        };

        // Función para abrir la ventana de ingreso del código
        const abriVentanaCodigo = (callback) => {
          // Aquí se manejará la ventana donde se ingresa el código.
          const codeInputElement = document.querySelector("#codeNumbre_1");

          // Agregar evento para cuando se ingresa el código completo
          codeInputElement.addEventListener("input", () => {
            const code = codeInputElement.value;

            // Verificar si el código tiene la longitud esperada
            if (code.length === 6) {
              callback(code);
            }
          });

          // Mostrar ventana para ingresar código (esto debería abrir el modal o lightbox)
          // Ejemplo de código para mostrar la ventana:
          document.querySelector("#code-lightbox").style.display = "block";
        };

        // Configura los botones de registro para cada padre/acudiente
        let handleButtonParent = (parentId, parentName, parentEmail) => {
          listItem.classList.toggle("active");

          const buttonManual = document.createElement("button");
          const buttonQR = document.createElement("button");

          buttonManual.setAttribute("type", "button");
          buttonQR.setAttribute("type", "button");

          buttonManual.innerHTML = `<svg width="127" height="127" viewBox="0 0 127 127" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M119.93 56.8967L97.288 32.0107C95.2378 29.9787 91.7544 29.9727 89.6013 32.1136C88.525 33.1899 87.9563 34.5688 87.9563 36.0384C87.9563 37.5079 88.5309 38.8927 89.571 39.9331L89.831 40.1931C91.0102 41.3724 91.0102 43.2896 89.831 44.4688C88.6758 45.63 86.8011 45.6541 85.6159 44.5292C85.6159 44.5292 85.6159 44.5233 85.6099 44.5233H85.604C85.604 44.5233 85.604 44.5233 85.598 44.5173L85.5921 44.5114C85.5921 44.5114 85.598 44.5114 85.5861 44.5054L79.2421 38.1614C77.1012 36.0205 73.5996 36.0205 71.4588 38.1614C69.2757 40.3445 69.2757 43.8341 71.4225 45.9809L77.7302 52.2887C78.323 52.8815 78.6133 53.6554 78.6133 54.4296C78.6133 55.2037 78.3171 55.9776 77.7302 56.5704C76.551 57.7497 74.6338 57.7497 73.4545 56.5704L61.0992 44.2092C58.9583 42.0683 55.4568 42.0683 53.3159 44.2092C51.1328 46.3923 51.1328 49.8819 53.2796 52.0287L65.6349 64.384C66.2277 64.9768 66.518 65.7507 66.518 66.5249C66.518 67.2991 66.2217 68.073 65.6349 68.6657C64.4556 69.845 62.5384 69.845 61.3591 68.6657L31.1091 38.4091C30.0327 37.3327 28.6235 36.7944 27.2143 36.7944C25.8051 36.7944 24.3962 37.3327 23.3195 38.4032C21.1424 40.5863 21.1424 44.0819 23.2892 46.2287L68.6645 91.604C69.4687 92.4082 69.7531 93.5997 69.4024 94.6761C69.0455 95.7587 68.1202 96.5508 66.9953 96.7262L36.6664 101.492C32.9834 102.018 30.2379 105.181 30.2379 108.858C30.2379 110.527 31.5927 111.882 33.2618 111.882H90.2848C97.5541 111.882 104.388 109.051 109.528 103.911L119.041 94.3983C124.176 89.2636 127 82.4418 127 75.1847C127 68.4052 124.484 61.9101 119.93 56.8967Z" fill="#0CB5C3"/><path d="M51.9852 31.1637C47.5828 21.4209 37.8582 15.1191 27.2143 15.1191C12.2101 15.1191 0 27.3293 0 42.3334C0 52.9773 6.30153 62.7019 16.0442 67.1106C16.4493 67.292 16.8729 67.3768 17.2901 67.3768C18.4391 67.3768 19.5399 66.7115 20.0479 65.5988C20.7313 64.0748 20.0538 62.2846 18.536 61.5952C10.9523 58.1662 6.04781 50.6066 6.04781 42.3334C6.04781 30.6616 15.5425 21.1667 27.2146 21.1667C35.4877 21.1667 43.0473 26.0712 46.4763 33.6549C47.1598 35.1789 48.956 35.8624 50.4737 35.1667C51.9974 34.4776 52.6747 32.6877 51.9852 31.1637Z" fill="#0CB5C3"/></svg> Registro manual</span>`;
          buttonQR.innerHTML = `<svg width="127" height="127" viewBox="0 0 127 127" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M3.7207 29.7656C1.66588 29.7656 0 28.0997 0 26.0449V3.7207C0 1.66588 1.66588 0 3.7207 0H26.0449C28.0997 0 29.7656 1.66588 29.7656 3.7207C29.7656 5.77552 28.0997 7.44141 26.0449 7.44141H7.44141V26.0449C7.44141 28.0997 5.77552 29.7656 3.7207 29.7656Z" fill="#0CB5C3"/><path d="M123.279 29.7656C121.224 29.7656 119.559 28.0997 119.559 26.0449V7.44141H100.955C98.9003 7.44141 97.2344 5.77552 97.2344 3.7207C97.2344 1.66588 98.9003 0 100.955 0H123.279C125.334 0 127 1.66588 127 3.7207V26.0449C127 28.0997 125.334 29.7656 123.279 29.7656Z" fill="#0CB5C3"/><path d="M26.0449 127H3.7207C1.66588 127 0 125.334 0 123.279V100.955C0 98.9003 1.66588 97.2344 3.7207 97.2344C5.77552 97.2344 7.44141 98.9003 7.44141 100.955V119.559H26.0449C28.0997 119.559 29.7656 121.224 29.7656 123.279C29.7656 125.334 28.0997 127 26.0449 127Z" fill="#0CB5C3"/><path d="M123.279 127H100.955C98.9003 127 97.2344 125.334 97.2344 123.279C97.2344 121.224 98.9003 119.559 100.955 119.559H119.559V100.955C119.559 98.9003 121.224 97.2344 123.279 97.2344C125.334 97.2344 127 98.9003 127 100.955V123.279C127 125.334 125.334 127 123.279 127Z" fill="#0CB5C3"/><path d="M74.6621 52.3379H96.9863V30.0137H74.6621V52.3379ZM85.8242 37.4551C87.879 37.4551 89.5449 39.121 89.5449 41.1758C89.5449 43.2306 87.879 44.8965 85.8242 44.8965C83.7694 44.8965 82.1035 43.2306 82.1035 41.1758C82.1035 39.121 83.7694 37.4551 85.8242 37.4551Z" fill="#0CB5C3"/><path d="M74.6621 89.5449H82.1035V96.9863H74.6621V89.5449Z" fill="#0CB5C3"/><path d="M30.0137 96.9863H52.3379V74.6621H30.0137V96.9863ZM41.1758 82.1035C43.2306 82.1035 44.8965 83.7694 44.8965 85.8242C44.8965 87.879 43.2306 89.5449 41.1758 89.5449C39.121 89.5449 37.4551 87.879 37.4551 85.8242C37.4551 83.7694 39.121 82.1035 41.1758 82.1035Z" fill="#0CB5C3"/><path d="M30.0137 52.3379H52.3379V30.0137H30.0137V52.3379ZM41.1758 37.4551C43.2306 37.4551 44.8965 39.121 44.8965 41.1758C44.8965 43.2306 43.2306 44.8965 41.1758 44.8965C39.121 44.8965 37.4551 43.2306 37.4551 41.1758C37.4551 39.121 39.121 37.4551 41.1758 37.4551Z" fill="#0CB5C3"/><path d="M100.707 15.1309H26.293C20.1283 15.1309 15.1309 20.1283 15.1309 26.293V100.707C15.1309 106.872 20.1283 111.869 26.293 111.869H100.707C106.872 111.869 111.869 106.872 111.869 100.707V26.293C111.869 20.1283 106.872 15.1309 100.707 15.1309ZM59.7793 100.707C59.7793 102.762 58.1134 104.428 56.0586 104.428H26.293C24.2381 104.428 22.5723 102.762 22.5723 100.707V70.9414C22.5723 68.8866 24.2381 67.2207 26.293 67.2207H56.0586C58.1134 67.2207 59.7793 68.8866 59.7793 70.9414V100.707ZM59.7793 56.0586C59.7793 58.1134 58.1134 59.7793 56.0586 59.7793H26.293C24.2381 59.7793 22.5723 58.1134 22.5723 56.0586V26.293C22.5723 24.2381 24.2381 22.5723 26.293 22.5723H56.0586C58.1134 22.5723 59.7793 24.2381 59.7793 26.293V56.0586ZM89.5449 100.707C89.5449 102.762 87.879 104.428 85.8242 104.428H70.9414C68.8866 104.428 67.2207 102.762 67.2207 100.707V85.8242C67.2207 83.7694 68.8866 82.1035 70.9414 82.1035H85.8242C87.879 82.1035 89.5449 83.7694 89.5449 85.8242V100.707ZM104.428 100.707C104.428 102.762 102.762 104.428 100.707 104.428C98.6522 104.428 96.9863 102.762 96.9863 100.707V95.7461C96.9863 93.6913 98.6522 92.0254 100.707 92.0254C102.762 92.0254 104.428 93.6913 104.428 95.7461V100.707ZM104.428 80.8633C104.428 82.9181 102.762 84.584 100.707 84.584C98.6522 84.584 96.9863 82.9181 96.9863 80.8633V74.6621H70.9414C68.8866 74.6621 67.2207 72.9962 67.2207 70.9414C67.2207 68.8866 68.8866 67.2207 70.9414 67.2207H100.707C102.762 67.2207 104.428 68.8866 104.428 70.9414V80.8633ZM104.428 56.0586C104.428 58.1134 102.762 59.7793 100.707 59.7793H70.9414C68.8866 59.7793 67.2207 58.1134 67.2207 56.0586V26.293C67.2207 24.2381 68.8866 22.5723 70.9414 22.5723H100.707C102.762 22.5723 104.428 24.2381 104.428 26.293V56.0586Z" fill="#0CB5C3"/></svg> Registro por QR</span>`;

          // Escucha para el botón de registro manual
          buttonManual.addEventListener("click", () =>
            manualHandle(parentId, parentName, parentEmail)
          );

          buttonQR.addEventListener("click", qrHandle);

          const contentContainer = document.createElement("div");
          contentContainer.classList.add("methods-register");
          contentContainer.appendChild(buttonManual);
          contentContainer.appendChild(buttonQR);

          showInfoLightbox(
            "Selecciona tu método de registro",
            contentContainer
          );
        };

        // Renderiza los botones de padres/acudientes
        renderAcuarelaUserButtons(
          kid.acuarelausers,
          acuarelaUsersContainer,
          handleButtonParent
        );
      });
      container.appendChild(fragment);
    };

    const renderKidsInactive = (kids, container, iconClass) => {
      const fragment = document.createDocumentFragment();
      kids.forEach((kid) => {
        const template = createKidInaciveTemplate(kid, iconClass);
        const listItem = document.createElement("li");
        listItem.innerHTML = template;
        fragment.appendChild(listItem);
      });
      container.appendChild(fragment);
    };

    renderKids(inDaycare, containerindaycare, "acuarela-Aceptar", "checkout");
    renderKids(notInDaycare, containerinhome, "acuarela-Casa", "checkin");
    renderKidsInactive(inactives, containerinactive, "");
    fadeOut(preloader);
  }
};

// Lightbox de finanzas
const subirplan = () => {
  const contentContainer = document.createElement("div");
  contentContainer.classList.add("methods-register");

  const linkMensual = document.createElement("a");
  linkMensual.href = "https://buy.stripe.com/9AQbMx2Fa7zHb2E7sV";
  linkMensual.classList.add("precios");
  linkMensual.innerHTML = `
    <img src="img/icons/clip_path_group.svg"" alt="file">
    <span>Acuarela Pro </span>
    <p class=price">$24 / mes</p>
  `;
  const linkAnual = document.createElement("a");
  linkAnual.href = "https://buy.stripe.com/28o2bXcfK6vDgmYbJa";
  linkAnual.classList.add("precios");
  linkAnual.innerHTML = `
    <img src="img/icons/clip_path_group.svg"" alt="file">
    <span>Acuarela Pro </span>
    <p class=price">$249 / anual</p>
  `;

  contentContainer.appendChild(linkMensual);
  contentContainer.appendChild(linkAnual);

  showInfoLightbox("Escoge el tipo de suscripción que desea", contentContainer);
};

const targetId = "66e99e236624c5230df59cec"; // ID de Acuarela PRO

// Función que se ejecuta si el ID es diferente del objetivo (para mostrar el lightbox)
function showLightboxFinanzas() {
  const contentContainer = document.createElement("div");
  contentContainer.classList.add("methods-finanzas");

  contentContainer.innerHTML = `
    <p>Descubre el poder de una gestión integral para tu Daycare con Acuarela Pro, administra tus gastos, ingresos y genera facturas automáticas para Padres.</p>
    <ul>
      <li>Administra niños sin límite.</li>
      <li>Administra tus gastos, reportes financieros avanzados.</li>
      <li>Administra tus ingresos.</li>
      <li>Facturación automática y profesional para padres.</li>
      <li>Recibe pagos electrónicos de padres. (Comisión por transacción: USD0.50)</li>
    </ul>
  `;

  const contentPlan = document.createElement("button");
  contentPlan.classList.add("btn", "btn-action-primary", "enfasis", "btn-big");
  contentPlan.innerText = "Obtener versión PRO";
  contentPlan.addEventListener("click", subirplan);

  contentContainer.appendChild(contentPlan);

  showInfoLightbox(
    "Para obtener mis finanzas es necesario comprar la versión PRO",
    contentContainer
  );
}

// Verifica si el ID de suscripción es igual al objetivo
function validarSuscripcion() {
  let accesoPermitido = false; // Por defecto, no permitir el acceso
  suscripcionIds.forEach(function (id) {
    if (
      id === "66dfcce23f91241d635ae934" ||
      id === "66df29c33f91241d635ae818"
    ) {
      accesoPermitido = true; // Si se encuentra el ID, permir el acceso
    }
  });
  return accesoPermitido;
}

// Al hacer clic en el botón de finanzas
const finanzas_lightbox = document.getElementById("lightbox-finanzas");
if (finanzas_lightbox) {
  finanzas_lightbox.addEventListener("click", function (event) {
    if (validarSuscripcion()) {
      // Si el ID es correcto, redirigir a la página de finanzas
      window.location.href = "/miembros/acuarela-app-web/finanzas";
    } else {
      // Si no, mostrar el lightbox
      showLightboxFinanzas();
    }
  });
}

// Validar acceso al cargar la página directamente
document.addEventListener("DOMContentLoaded", function () {
  const mainFinanzas = document.getElementById("Finanzas");

  if (window.location.href.includes("/miembros/acuarela-app-web/finanzas")) {
    if (!validarSuscripcion()) {
      if (mainFinanzas) {
        mainFinanzas.innerHTML = ""; // Limpiar el contenido de <main id="Finanzas">
      }
      showLightboxFinanzas();
    }
  }
});

//================> APARTADO EMERGENCIA <===================
//==> AL HACER CLICK EN EL BOTON CONTACTO DE EMERGENCIAS
const emergencycontact_lightbox = document.getElementById(
  "lightbox-emergencycontact"
);
if (emergencycontact_lightbox) {
  emergencycontact_lightbox.addEventListener("click", function (event) {
    if (window.innerWidth > 425) {
      showLightboxParient();
    } else {
      showLightboxEmergency();
    }
  });
}

// =====> Lightbox CONTACTO DE EMERGENCIA <===
function showLightboxEmergency() {
  const contentContainer = document.createElement("div");
  contentContainer.classList.add("methods-emergency");

  //Boton para redirigir a llamar a emergencias
  const linkEmergencia = document.createElement("a");
  linkEmergencia.classList.add("emergency");
  linkEmergencia.innerHTML = `
    <img src="img/icons/telefono.svg"" alt="file">
    <span>Llamar a emergencias </span>
  `;
  linkEmergencia.addEventListener("click", (event) => {
    showLightboxCallEmergency();
  });

  //Boton para redirigir a opciones de contacto con el pariente
  const linkPariente = document.createElement("a");
  linkPariente.classList.add("emergency");
  linkPariente.innerHTML = `
    <img src="img/icons/familia.svg" alt="file">
    <span>Contactar al pariente</span>
  `;
  linkPariente.addEventListener("click", (event) => {
    showLightboxParient();
  });

  contentContainer.appendChild(linkEmergencia);
  contentContainer.appendChild(linkPariente);
  showInfoLightbox("Contacto de emergencia", contentContainer);
}

// =====> Lightbox de LLAMAR A EMERGENCIAS <===
function showLightboxCallEmergency() {
  const contentContainer = document.createElement("div");
  contentContainer.classList.add("methods-callemergency");

  //Boton para llamar directamente a Urgencias en USA
  const Urgencias = document.createElement("a");
  Urgencias.setAttribute("href", "tel:911");
  Urgencias.classList.add("emergency");
  Urgencias.innerHTML = `
    <img src="img/icons/RH.svg"" alt="file">
    <span>Urgenicas 911 </span>
  `;

  //Boton para llamar directamente a la Policia en USA
  const Policia = document.createElement("a");
  Policia.setAttribute("href", "tel:+12126391991");
  Policia.classList.add("emergency");
  Policia.innerHTML = `
    <img src="img/icons/Escudo.svg"" alt="file">
    <span>Policía </span>
  `;

  contentContainer.appendChild(Urgencias);
  contentContainer.appendChild(Policia);
  showInfoLightbox("LLamar a emergencias", contentContainer);
}

// Función para mostrar el mensaje dinámico ============================
function showMessage(container, text, isError = false) {
  const existingMessage = container.querySelector(".response-message"); // Elimina mensajes previos
  if (existingMessage) {
    existingMessage.remove();
  }
  // Crea el mensaje
  const message = document.createElement("p");
  message.classList.add("response-message");
  message.innerHTML = `
    <i class="acuarela acuarela-Informacion"></i>
    ${text}
  `;
  container.appendChild(message); // Agrega el mensaje al contenedor
  setTimeout(() => {
    if (message.parentElement) {
      message.remove();
    }
  }, 7000); // 7000 ms = 7 segundos
}

// Función para ENVIAR CORREO  de emergencias ===========================
function sendEmergencyEmail(
  gravedad,
  email,
  email2,
  name,
  name2,
  lastname,
  lastname2,
  reportedFor,
  incidentType,
  temperature,
  actionsTaken,
  severityLevel,
  suggestedActions
) {
  let messagegrav = "";
  let messagegrav2 = "";
  if (gravedad === "grave") {
    messagegrav = `Queremos informarle que se ha presentado una situación que requiere atención inmediata. Hemos contactado a emergencias y tomado las medidas necesarias para garantizar la seguridad de su hijo/a.`;
    messagegrav2 = `Le solicitamos amablemente que acuda al daycare lo antes posible para que podamos continuar brindando el mejor apoyo a su hijo/a junto con usted.`;
  } else {
    messagegrav = `Queremos informarle que su hijo/a ha tenido un incidente durante su estancia en el daycare. A continuación, le proporcionamos los detalles relevantes:`;
    messagegrav2 = `Si bien hemos actuado de inmediato para atender la situación, consideramos importante su pronta presencia para garantizar el bienestar de su hijo/a y tomar cualquier acción adicional que sea necesaria.`;
  }
  // Datos que se enviarán al webhook
  const data = {
    subject: "Urgencia de salud - Favor recoger a su hijo",
    name_user: name,
    lastname_user: lastname,
    name_user2: name2,
    lastname_user2: lastname2,
    reportado_por: reportedFor,
    gravedad_buttom: gravedad,
    gravedad_child: severityLevel,
    tipo_incidente: incidentType,
    temperatura: temperature,
    acciones_tomadas: actionsTaken,
    acciones_esperadas: suggestedActions,
    message: messagegrav,
    message2: messagegrav2,
    to: email,
    to2: email2,
  };
  const container = document.querySelector(".methods-emergency");
  // Enviar solicitud al webhook de Make
  fetch("https://hook.us1.make.com/mtmdvt7v8sbd0bdalpyjngbxbhi3sryr", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(data),
  })
    .then((response) => {
      if (response.ok) {
        showMessage(
          container,
          "Se ha enviado un mensaje de aviso al pariente."
        );
      } else {
        showMessage(
          container,
          "Hubo un error al enviar el correo. Por favor, inténtelo nuevamente.",
          true
        );
      }
    })
    .catch((error) => {
      console.error("Error:", error);
      showMessage(container, "Hubo un error al enviar el correo.", true);
    });
}

// Botones flotantes del lightbox de EMERGENCIAS ========================
function buttonsFlot(linkElement, buttonData, top, left, width) {
  if (document.querySelector(".new-buttons-container")) return; // Evitar duplicados

  const buttonsContainer = document.createElement("div");
  buttonsContainer.classList.add("new-buttons-container");
  buttonsContainer.style.top = top;
  buttonsContainer.style.left = left;
  buttonsContainer.style.width = width;

  buttonData.forEach((data) => {
    let newButton;
    if (data.text === "Llamar") {
      newButton = document.createElement("a"); // Si el texto es "Llamar", crear un enlace con href "tel:911"
      newButton.href = `tel:${kidData.guardians[0].guardian_phone}`;
      newButton.target = "_self";
    } else if (data.href) {
      newButton = document.createElement("a"); // Crear un enlace si hay un href definido
      newButton.href = data.href;
      newButton.target = "_self";
    } else {
      newButton = document.createElement("p"); // Crear un botón si no hay un href
      if (data.action) {
        newButton.addEventListener("click", data.action);
      }
    }
    newButton.classList.add("new-emergency");
    newButton.innerHTML = `<i class="${data.iconClass}"></i> ${data.text}`;
    buttonsContainer.appendChild(newButton);
  });
  linkElement.parentNode.appendChild(buttonsContainer);
}

// Mostrar los guardians e informacion escencial de contacto ============
function dataParient(kidData) {
  const contentContainer = document.createElement("div");
  contentContainer.classList.add("parentslight");

  // Verificar si existen guardianes
  if (kidData.guardians && kidData.guardians.length > 0) {
    kidData.guardians.forEach((guardian, index) => {
      const parientsLight = document.createElement("div");
      parientsLight.classList.add("parentslight-div");
      const parienteContactContainer = document.createElement("div");
      parienteContactContainer.classList.add("parentslight-left");
      const parientecontact = document.createElement("p");

      // Cambiar el mensaje según el índice
      parientecontact.textContent = `${index + 1}. Contacto de emergencia`;
      parienteContactContainer.appendChild(parientecontact);

      // Crear el contenedor para los datos del pariente (derecha)
      const parienteDataContainer = document.createElement("div");
      parienteDataContainer.classList.add("parentslight-right");
      const nombre = `${guardian.guardian_name || "No disponible"} ${guardian.guardian_lastname || ""
        }`.trim();
      const telefono = guardian.guardian_phone || "No disponible";
      const email = guardian.guardian_email || "No disponible";
      const datosPariente = [
        `<strong>Nombre: </strong> ${nombre || "No disponible"}`,
        `<strong>Teléfono: </strong> ${telefono}`,
        `<strong>Email: </strong> ${email}`,
      ];

      datosPariente.forEach((dato) => {
        const parienteData = document.createElement("p");
        parienteData.classList.add("parentslight-contact");
        parienteData.innerHTML = dato;
        parienteDataContainer.appendChild(parienteData);
      });

      parientsLight.appendChild(parienteContactContainer);
      parientsLight.appendChild(parienteDataContainer);
      contentContainer.appendChild(parientsLight);
    });
  } else {
    // Si no hay guardianes, mostrar mensaje "No existe contacto de emergencia"
    const noContactMessage = document.createElement("p");
    noContactMessage.textContent = "No existe contacto de emergencia";
    noContactMessage.classList.add("no-contact-message");
    contentContainer.appendChild(noContactMessage);
  }
  return contentContainer;
}

// =====> Lightbox CONTACTAR CON PARIENTE SEGUN GRAVEDAD <===
function showLightboxParient() {
  const contentContainer = document.createElement("div");
  contentContainer.classList.add("methods-emergency");

  //Boton para enviar email a parientes de manera urgente
  const linkGrave = document.createElement("a");
  linkGrave.classList.add("emergency");
  linkGrave.innerHTML = `
    <img class="emergencyimg" src="img/icons/Padre.svg"" alt="file">
    <span>Caso Urgente</span>
  `;
  linkGrave.addEventListener("click", () => {
    if (window.innerWidth <= 425) {
      linkModerado.style.opacity = "0.5";
      const buttonDataGrave = [
        { text: "Llamar", iconClass: "acuarela acuarela-Telefono" },
        { text: "Texto", iconClass: "acuarela acuarela-Habla" },
        {
          text: "Email",
          iconClass: "acuarela acuarela-Mensajes",
          action: () => {
            const gravedad = "grave";
            const email = kidData.guardians[0].guardian_email;
            const name = kidData.guardians[0].guardian_name;
            const lastname = kidData.guardians[0].guardian_lastname;
            sendEmergencyEmail(
              gravedad,
              email,
              null,
              name,
              null,
              lastname,
              null,
              null,
              null,
              null,
              null,
              null,
              null
            );
          },
        },
      ];
      buttonsFlot(linkGrave, buttonDataGrave, "145px", "55px", "86px");
    } else {
      const gravedad = "grave";
      const email = kidData.guardians[0].guardian_email;
      const name = kidData.guardians[0].guardian_name;
      const lastname = kidData.guardians[0].guardian_lastname;
      sendEmergencyEmail(
        gravedad,
        email,
        null,
        name,
        null,
        lastname,
        null,
        null,
        null,
        null,
        null,
        null,
        null
      );
    }
  });

  //Boton para enviar email con un reporte mas detallado despues de haber llenado la incidencia
  const linkModerado = document.createElement("a");
  linkModerado.classList.add("emergency");
  linkModerado.innerHTML = `
    <img class="emergencyimg-2" src="img/icons/Formulario.svg" alt="file">
    <span>Enviar reporte detallado</span>
  `;
  linkModerado.addEventListener("click", () => {
    const container = document.querySelector(".methods-emergency");
    if (
      !kidData.healthinfo?.incidents ||
      kidData.healthinfo?.incidents.length === 0
    ) {
      showMessage(
        container,
        "El reporte detallado requiere llenar la incidencia ocurrida el dia de hoy."
      );
      linkGrave.style.opacity = "0.5";
      let topPosition = "170px";
      let leftPosition = "500px";
      if (window.innerWidth <= 768) {
        topPosition = "100px";
        leftPosition = "450px";
      }
      if (window.innerWidth <= 425) {
        topPosition = "370px";
        leftPosition = "230px";
      }
      if (window.innerWidth <= 320) {
        topPosition = "390px";
        leftPosition = "180px";
      }
      const buttonDataModerado = [
        {
          text: "Llenar reporte",
          iconClass: "acuarela acuarela-Telefono",
          href: `/miembros/acuarela-app-web/agregar-reporte/${kidData._id}`,
        },
      ];
      buttonsFlot(
        linkModerado,
        buttonDataModerado,
        topPosition,
        leftPosition,
        "120px"
      );
      return;
    }

    // Obtener la fecha actual ajustada a Nueva York (sin la hora)
    const now = new Date();
    const options = {
      timeZone: "America/New_York",
      year: "numeric",
      day: "2-digit",
      month: "2-digit",
    };
    const formatter = new Intl.DateTimeFormat("en-US", options);
    const parts = formatter.formatToParts(now);
    const todayNY = `${parts[4].value}-${parts[0].value}-${parts[2].value}`; // Año-Mes-Día
    let matchFound = false; // Variable para saber si existe un match
    console.log("todayNY: ", todayNY);

    for (let i = 0; i < kidData.healthinfo.incidents.length; i++) {
      const incident = kidData.healthinfo.incidents[i];
      const reportedDate = incident.reported_enf;
      const reportedFor = incident.reported_for;
      console.log("reportedDate: ", reportedDate);
      console.log("todayNY: ", todayNY);

      if (reportedDate === todayNY) {
        const gravedad = "moderado";
        const email = kidData.guardians[0]?.guardian_email || "";
        const lastname = kidData.guardians[0]?.guardian_lastname || "";
        const name = kidData.guardians[0]?.guardian_name || "";
        const email2 = kidData.guardians[1]?.guardian_email || "";
        const name2 = kidData.guardians[1]?.guardian_name || "";
        const lastname2 = kidData.guardians[1]?.guardian_lastname || "";
        const incidentType = incident.description || "No registrado";
        const temperature = incident.temperature || "No registrado";
        const actionsTaken = incident.actions_taken || "No registrado";
        const severityLevel = incident.gravedad || "No registrado";
        const suggestedActions = incident.actions_expected || "No registrado";
        sendEmergencyEmail(
          gravedad,
          email,
          email2,
          name,
          name2,
          lastname,
          lastname2,
          reportedFor,
          incidentType,
          temperature,
          actionsTaken,
          severityLevel,
          suggestedActions
        );
        matchFound = true; // Indicar que se encontro una coincidencia
        break;
      }
    }

    if (!matchFound) {
      const container = document.querySelector(".methods-emergency");
      showMessage(
        container,
        "El reporte detallado requiere llenar la incidencia ocurrida el dia de hoy."
      );
      linkGrave.style.opacity = "0.5";
      let topPosition = "170px";
      let leftPosition = "500px";
      if (window.innerWidth <= 768) {
        topPosition = "100px";
        leftPosition = "450px";
      }
      if (window.innerWidth <= 425) {
        topPosition = "370px";
        leftPosition = "230px";
      }
      if (window.innerWidth <= 320) {
        topPosition = "390px";
        leftPosition = "180px";
      }
      const buttonDataModerado = [
        {
          text: "Llenar reporte",
          iconClass: "acuarela acuarela-Telefono",
          href: `/miembros/acuarela-app-web/agregar-reporte/${kidData._id}`,
        },
      ];
      buttonsFlot(
        linkModerado,
        buttonDataModerado,
        topPosition,
        leftPosition,
        "120px"
      );
    }
    window.location.href = `/miembros/acuarela-app-web/ninxs/${kidData._id}`;
  });
  contentContainer.appendChild(linkGrave);
  contentContainer.appendChild(linkModerado);

  const parientsLight = dataParient(kidData);
  contentContainer.appendChild(parientsLight);
  showInfoLightbox(
    "Contactar con pariente según nivel de gravedad",
    contentContainer
  );
}

//================> APARTADO SALUD <===================
// =====> Enviar datos al collection HEALTHINFO en strapi para SALUD<===
const handleHealthInfo = async () => {
  fadeIn(preloader);
  const form = document.getElementById("healthInfoForm");
  const inputs = form.querySelectorAll("input, select, textarea");

  const formValues = {};
  inputs.forEach((input) => {
    if (input.type === "checkbox") {
      formValues[input.name] = input.checked ? input.value : "0";
    } else {
      formValues[input.name] = input.value;
    }
  });

  let dataToSend = {
    inscripcion: kidData.healthinfo ? kidData.healthinfo._id : null,
    child: kidData._id,
    asthma: formValues.asma,
    allergies: [...document.querySelectorAll("input[name='alergias']")].map(
      (input) => input.value
    ),
    medicines: [...document.querySelectorAll("input[name='medicamentos']")].map(
      (input) => input.value
    ),
    vacination: [...document.querySelectorAll("input[name='vacunas']")].map(
      (input) => input.value
    ),
    accidents: [...document.querySelectorAll("input[name='accidentes']")].map(
      (input) => input.value
    ),
    physical_health: formValues.salud_fisica,
    emotional_health: formValues.salud_emocional,
    suspected_abuse: formValues.sospecha_abuso,
    ointments: [...document.querySelectorAll("input[name='unguentos']")].map(
      (input) => input.value
    ),
    pediatrician: formValues.pedriatra,
    pediatrician_number: formValues.pedriatra_numero,
    pediatrician_email: formValues.pedriatra_email,
  };
  console.log(dataToSend);

  try {
    if (!kidData.healthinfo || kidData.healthinfo.child !== kidData._id) {
      const response = await fetch("s/createHealthInfo/", {
        method: "POST",
        body: JSON.stringify(dataToSend),
        headers: { "Content-Type": "application/json" },
      });
      const body = await response.json();

      if (body.id) {
        window.location.href = `/miembros/acuarela-app-web/ninxs/${kidData._id}`;
      }
    } else {
      const response = await fetch("s/updateHealthInfo/", {
        method: "PUT",
        body: JSON.stringify(dataToSend),
        headers: { "Content-Type": "application/json" },
      });
      const body = await response.json();

      if (body.id) {
        window.location.href = `/miembros/acuarela-app-web/ninxs/${kidData._id}`;
      } else {
        console.error("Error al actualizar HealthInfo: ", body);
      }
    }
  } catch (error) {
    console.error("Error handling healthinfo:", error);
    return false;
  }
};

// =====> Desplegar en vista para CELL el apartado UNGUENTOS
document.querySelectorAll(".ung-btn").forEach((btn) => {
  btn.addEventListener("click", function () {
    const content = this.parentElement.nextElementSibling;
    const icon = this.querySelector("i");
    content.classList.toggle("show");
    // Alterna las clases del ícono
    if (icon.classList.contains("acuarela-Flecha_arriba")) {
      icon.classList.remove("acuarela-Flecha_arriba");
      icon.classList.add("acuarela-Flecha_abajo");
    } else {
      icon.classList.remove("acuarela-Flecha_abajo");
      icon.classList.add("acuarela-Flecha_arriba");
    }
  });
});

// =====> Enviar datos al collection HEALTHINFO en strapi para INCIDENTES<===
const handleReportInfo = async () => {
  fadeIn(preloader);
  const form = document.getElementById("healthInfoForm");
  const inputs = form.querySelectorAll("input, select, textarea");

  const formValues = {};
  inputs.forEach((input) => {
    formValues[input.name] = input.value;
  });

  // Objtener fechas de hoy en hora New York
  const currentDate = new Date().toLocaleString("en-US", {
    timeZone: "America/New_York",
  });
  // Formatear la fecha (31/01/2025)
  const dateObj = new Date(currentDate);
  const reportedenf = `${dateObj.getFullYear()}-${(dateObj.getMonth() + 1)
    .toString()
    .padStart(2, "0")}-${dateObj.getDate().toString().padStart(2, "0")}`;

  let newIncident = {
    reported_for: formValues.reportado_por,
    incident_type: formValues["tipo-incidente"],
    description: formValues.descripcion,
    temperature: formValues.temperatura,
    gravedad: formValues["levelgrave"],
    statehealth: formValues["statehealth"],
    actions_taken: formValues.acciones_tomadas,
    actions_expected: formValues.acciones_esperadas,
    reported_enf: reportedenf,
    // reported_enh: "15:00"
  };

  let dataToSend = {
    inscripcion: kidData.healthinfo ? kidData.healthinfo._id : null,
    child: kidData._id,
    incidents: kidData.healthinfo?.incidents
      ? [...kidData.healthinfo.incidents, newIncident] // Agrega el nuevo incidente
      : [newIncident], // Si no existen incidentes, crea el array con el primero
  };
  console.log("Enviando datos:", dataToSend);

  const endpoint =
    kidData.healthinfo && kidData.healthinfo.child === kidData._id
      ? "s/updateHealthInfo/"
      : "s/createHealthInfo/";

  const method = endpoint.includes("update") ? "PUT" : "POST";

  try {
    const response = await fetch(endpoint, {
      method: method,
      body: JSON.stringify({
        ...dataToSend,
        inscripcion: kidData.healthinfo ? kidData.healthinfo._id : null,
      }),
      headers: { "Content-Type": "application/json" },
    });
    const result = await response.json();
    console.log("Respuesta del servidor:", result); // Verifica qué devuelve exactamente

    if (!response.ok) {
      throw new Error(`Error ${response.status}: ${result.message}`);
    }
    localStorage.setItem("showEmergencyButton", "true");
    window.location.href = `/miembros/acuarela-app-web/agregar-reporte/${kidData._id}`;
  } catch (error) {
    console.error("Error al agregar incidente:", error);
  }
};

// =====> Desplegar los Incidentes
const incidents = document.querySelectorAll(".incidentnino");
incidents.forEach((incident) => {
  const toggleContainer = incident.querySelector(".incidentnino-desp");
  const incidentInfo = incident.querySelector(".incidentinfo");
  const iconContainer = incident.querySelector(".iconincid");

  toggleContainer.addEventListener("click", function () {
    incidentInfo.classList.toggle("incidentdesp");
    iconContainer.classList.toggle("rotate");
  });
});

//================> APARTADO HEALTH CHECK <===================
// =====> Enviar datos al collection HEALTHINFO en strapi para HEALTH CHECK <===
const handleHelthCheckInfo = async (temperatura, reporte, fecha) => {
  const closeButton = document.getElementById("info-close-button"); // Ocultar el lightbox antes de enviar la información
  if (closeButton) closeButton.click();
  fadeIn(preloader);

  // Objtener fecha actual en hora New York
  const currentDate = new Date().toLocaleString("en-US", {
    timeZone: "America/New_York",
  });
  const dateObj = new Date(currentDate);
  const reportedenf = `${dateObj.getFullYear()}-${(dateObj.getMonth() + 1)
    .toString()
    .padStart(2, "0")}-${dateObj.getDate().toString().padStart(2, "0")}`;

  const fechaFinal = fecha === "null" || !fecha ? reportedenf : fecha;

  let newHealthCheck = {
    temperature: temperatura,
    report: reporte,
    bodychild: kidData.healthinfo.healthcheck.bodychild,
    daily_fecha: fechaFinal,
  };

  let dataToSend = {
    inscripcion: kidData.healthinfo ? kidData.healthinfo._id : null,
    child: kidData._id,
    healthcheck: kidData.healthinfo.healthcheck
      ? [...kidData.healthinfo.healthcheck, newHealthCheck]
      : [newHealthCheck],
  };

  console.log("Enviando datos:", dataToSend);

  try {
    const response = await fetch("s/updateHealthInfo/", {
      method: "POST",
      body: JSON.stringify(dataToSend),
      headers: { "Content-Type": "application/json" },
    });
    const body = await response.json();

    if (body.id) {
      enviarCorreo(); // **Actualizar y enviar los datos correctamente después de seleccionar**
      window.location.href = `/miembros/acuarela-app-web/ninxs/${kidData._id}`;
    } else {
      console.error("Error al actualizar HealthInfo: ", body);
    }
  } catch (error) {
    console.error("Error al agregar incidente:", error);
  }

  // Para enviar correo a papas con el reporte diario del nino
  function enviarCorreo() {
    const data = {
      nino_name: kidData.name || "null",
      nino_lastname: kidData.lastname || "null",
      mama_email: kidData.acuarelausers[0]?.mail || "null",
      papa_email: kidData.acuarelausers[1]?.mail || "null",
      mama_name: kidData.acuarelausers[0]?.name || "null",
      papa_name: kidData.acuarelausers[1]?.name || "null",
      mama_lastname: kidData.acuarelausers[0]?.lastname || "null",
      papa_lastname: kidData.acuarelausers[1]?.lastname || "null",
      temperature: temperatura || "null",
      report: reporte || "null",
      fechaSeleccionada: fechaFinal || "null",
      selectedArea: kidData.healthinfo.healthcheck.bodychild || "null",
    };

    fetch("https://hook.us1.make.com/cbdmhuh35metbkz34tbv8byw7kxiyhk7", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    })
      .then((response) => response.json()) // Si se recibe una respuesta, convertirla a JSON
      .then((data) => {
        console.log("Respuesta del webhook:", data);
      });
    // .catch((error) => {
    //   console.error("Error al enviar los datos:", error);
    // });
  }
};

// ...
function formatFechaHealth(fecha) {
  const opciones = {
    year: "numeric",
    month: "long",
    day: "2-digit",
    timeZone: "America/New_York",
  };

  let fechaObj;
  if (!fecha || fecha === "null") {
    // Obtener la fecha actual en Nueva York
    const ahora = new Date();
    const ahoraNY = new Intl.DateTimeFormat("en-US", {
      timeZone: "America/New_York",
    })
      .formatToParts(ahora)
      .reduce((acc, part) => {
        if (part.type === "year") acc.year = part.value;
        if (part.type === "month") acc.month = part.value;
        if (part.type === "day") acc.day = part.value;
        return acc;
      }, {});

    // Crear la fecha y sumar un día
    fechaObj = new Date(
      `${ahoraNY.year}-${ahoraNY.month.padStart(2, "0")}-${ahoraNY.day.padStart(
        2,
        "0"
      )}T00:00:00`
    );
    fechaObj.setDate(fechaObj.getDate());
  } else {
    // Mantener la fecha exacta sin modificarla
    const [year, month, day] = fecha.split("-");
    fechaObj = new Date(`${year}-${month}-${day}T00:00:00`);
  }

  // Extraer partes de la fecha formateada
  const formatter = new Intl.DateTimeFormat("es-ES", {
    month: "long",
    day: "2-digit",
    year: "numeric",
  });
  const partes = formatter.formatToParts(fechaObj);

  let dia, mes, año;
  partes.forEach((part) => {
    if (part.type === "day") dia = part.value.padStart(2, "0"); // Asegurar dos dígitos
    if (part.type === "month") mes = part.value;
    if (part.type === "year") año = part.value;
  });
  // Retornar en formato "Febrero 02/2025"
  return `${mes.charAt(0).toUpperCase() + mes.slice(1)} ${dia}/${año}`;
}

// =====> Primer lightbox para AGREGAR REPORTE <===
function showLightboxAddHealthCkeck(fechaSeleccionada, origen, kid = null) {
  let kidGlobal = origen === 1 ? kid : kidData;
  const contentContainer = document.createElement("div");
  contentContainer.classList.add("methods-daylihealth");
  const titleElement = document.getElementById("info-lightbox-title");
  const originalTextAlign = titleElement.style.textAlign;
  const originalmarginBottom = titleElement.style.marginBottom;
  titleElement.style.textAlign = "start";
  titleElement.style.marginBottom = "35px";
  console.log("Fecha:", fechaSeleccionada);
  console.log("Datos:", kidGlobal);

  // Acceder correctamente a las propiedades de kidData
  const photoUrl = kidData.photo
    ? "https://acuarelacore.com/api/" + kidData.photo.formats.small.url
    : null;
  const gender = kidData.gender;

  const infoNino = document.createElement("div");
  infoNino.classList.add("infonino");
  infoNino.innerHTML = `
    <div class="photo">
      ${photoUrl
      ? `
        <img loading="lazy" class="lazyload" src="img/placeholder.png" data-src="${photoUrl}" alt="${kidData.name}">
      `
      : `
        ${gender === "Masculino"
        ? '<img class="img-infonino" src="img/mal.png" alt="">'
        : ""
      }
        ${gender === "Femenino"
        ? '<img class="img-infonino" src="img/fem.png" alt="">'
        : ""
      }
        ${gender === "X"
        ? '<img class="img-infonino" src="img/Nonbinary.png" alt="">'
        : ""
      }
      `
    }
    </div>
    <div>
      <p class="infonino-name">${kidData.name}</p>
      <p class="infonino-hora">${formatFechaHealth(fechaSeleccionada)}</p>
    </div>
  `;

  const novedad = document.createElement("div");
  novedad.classList.add("novedadnino");
  novedad.innerHTML = `
    <div class="novedadnino-part">
      <span> Tienes alguna novedad con el Daily Health Check de ${kidData.name}? </span>
      <label class="novedadnino-label">
        <span> Sí </span>
        <input type="radio" name="novedad" value="si">
      </label>
      <label class="novedadnino-label">
        <span> No </span>
        <input type="radio" name="novedad" value="no">
      </label>
    </div>
  `;

  const reportTranslations = {
    "A-Absent": "Ausente",
    "B-Bruise": "Moretón",
    "C-Crusty Eyes": "Ojos con Costra",
    "CS-Cuts/Scrapes": "Cortes/raspaduras",
    "D-Diarrhea": "Diarrea",
    "E-Earache": "Dolor de oídos",
    "F-Feverish": "Febril",
    "FC-Flushed Complexion": "Tez enrojecida",
    "G-Glazed eyes": "Ojos vidriosos",
    "H-Headache": "Dolor de cabeza",
    "HA-Hyperactive": "Hiperactiva",
    "HL-Head Lice": "Piojos",
    "I-Irritable": "Irritable",
    "L-Listless": "Apáticio",
    "M-Mild Cough": "Tos leve",
    "N-Nasal Discharge": "Secreción nasal",
    "OK-Okay": "Okay",
    "OS-Open Sores": "Llagas abiertas",
    "P-Pale": "Pálida",
    "R-Rash": "Erupción",
    "S-Sleepy": "Somnolienta",
    "SC-Severe Cough": "Tos severa",
    "ST-Sore Throat": "Dolor de garganta",
    "V-Vomiting": "Vómitos",
    "W-Wheezing": "Sibilancia",
  };

  const dataNino = document.createElement("div");
  dataNino.classList.add("datanino");
  dataNino.innerHTML = `
    <div class="data">
      <span class="input-group">
          <i class="saludicon acuarela acuarela-Salud"></i>
          <label class="labelpediatra" for="temperatura">Temperatura: </label>
          <input type="text" placeholder="Agrega la temperatura" name="temperatura" id="temperatura" 
                value="${kidData.healthinfo?.healthcheck?.temperature || ""
    }" required>
          <span class="tempspan">°F</span>
          <span class="error-message"></span>
      </span>
      <span class="input-group">
          <i class="saludicon acuarela acuarela-Salud"></i>
          <label class="labelpediatra" for="report">Estado de Salud: </label>
          <select name="report" id="report" required>
            <option value="" disabled selected>Seleccione </option>
              ${Object.keys(reportTranslations)
      .map(
        (key) => `
                <option value="${key}" ${kidData.healthinfo?.healthcheck?.report === key
            ? "selected"
            : ""
          }>${key}</option>
                `
      )
      .join("")}
          </select>
          <p class="selected-report-container">
            <span class="circle-indicator"></span>
            <span id="selected-report">${kidData.healthinfo?.healthcheck?.report || "Sin seleccionar"
    }</span>
          </p>
          <p id="selected-report-es">${reportTranslations[kidData.healthinfo?.healthcheck?.report] || ""
    }</p>
          <span class="error-message"></span>
      </span>
    </div>      
  `;

  const selectReport = dataNino.querySelector("#report");
  const selectedReport = dataNino.querySelector("#selected-report");
  const selectedReportEs = dataNino.querySelector("#selected-report-es");

  selectReport.addEventListener("change", function () {
    selectedReport.textContent = this.value;
    selectedReportEs.textContent = reportTranslations[this.value] || "";
  });

  const databutton = document.createElement("div");
  databutton.classList.add("divbutton");
  databutton.innerHTML = `
    <div class="progress-indicator">
      
    </div>
    <button id="btnAgregar-reporte" class="btn btn-action-primary enfasis btn-big btn-disable"> Siguiente </button>   
  `;
  // Agregar evento al botón
  setTimeout(() => {
    const button = databutton.querySelector("#btnAgregar-reporte");
    const inputTemp = document.querySelector("#temperatura");
    const inputEstadoSalud = document.querySelector("#report");
    const radioButtons = document.querySelectorAll('input[name="novedad"]');
    button.setAttribute("disabled", "true"); // Bloquea el botón inicialmente
    button.style.cursor = "not-allowed"; // Cambia el cursor a no permitido

    function validateButton() {
      const selectedNovedad = document.querySelector(
        'input[name="novedad"]:checked'
      )?.value;
      const tempValue = inputTemp.value.trim();
      const estadoValue = inputEstadoSalud.value.trim();
      if (selectedNovedad === "no") {
        button.style.backgroundColor = "var(--cielo)";
        button.style.opacity = "1";
        button.disabled = false; // Habilitar el botón directamente
        button.style.cursor = "pointer";
      } else if (selectedNovedad === "si") {
        if (tempValue !== "" && estadoValue !== "") {
          button.style.backgroundColor = "var(--cielo)";
          button.style.opacity = "1";
          button.disabled = false;
          button.style.cursor = "pointer";
        } else {
          button.style.backgroundColor = "";
          button.disabled = true;
          button.style.cursor = "not-allowed";
        }
      }
    }

    // Verificar cada cambio en los radios
    radioButtons.forEach((radio) => {
      radio.addEventListener("change", validateButton);
    });
    // Verificar cada cambio en los inputs
    inputTemp.addEventListener("input", validateButton);
    inputEstadoSalud.addEventListener("change", validateButton);

    // Evento click para enviar los datos
    button.addEventListener("click", () => {
      const selectedNovedad = document.querySelector(
        'input[name="novedad"]:checked'
      )?.value;
      let temperature;
      let report;
      if (selectedNovedad === "no") {
        temperature = 98;
        report = "Ninguno";
      } else {
        temperature = inputTemp.value;
        report = inputEstadoSalud.value;
      }
      showLightboxAddBodyHealthCkeck(temperature, report, fechaSeleccionada);
    });
  }, 0);

  // Seleccionar elementos para manejar cambios en los radios (Ocultar o mostrar los inputs)
  const dataDiv = dataNino.querySelector(".data");
  const inputTemp = dataNino.querySelector("#temperatura");
  const inputEstadoSalud = dataNino.querySelector("#report");
  const radioButtons = novedad.querySelectorAll('input[name="novedad"]');
  dataDiv.style.opacity = "0.5";
  inputTemp.disabled = true;
  inputEstadoSalud.disabled = true;

  radioButtons.forEach((radio) => {
    radio.addEventListener("change", (event) => {
      if (event.target.value === "no") {
        dataNino.style.display = "none"; // Oculta el div completamente
        inputTemp.value = 98;
        inputEstadoSalud.value = "Ninguno";
        inputTemp.disabled = true;
        inputEstadoSalud.disabled = true;
      } else {
        dataNino.style.display = "flex"; // Muestra el div
        dataDiv.style.opacity = "1"; // Hace visibles los campos
        inputTemp.value = "";
        inputEstadoSalud.value = "";
        inputTemp.disabled = false;
        inputEstadoSalud.disabled = false;
      }
    });
  });

  contentContainer.appendChild(infoNino);
  contentContainer.appendChild(novedad);
  contentContainer.appendChild(dataNino);
  contentContainer.appendChild(databutton);
  showInfoLightbox("Daily Health Check", contentContainer);

  const closeButton = document.getElementById("info-close-button");
  const closeHandler = () => {
    titleElement.style.textAlign = originalTextAlign;
    titleElement.style.marginBottom = originalmarginBottom;
    closeButton.removeEventListener("click", closeHandler);
  };
  closeButton.addEventListener("click", closeHandler);
}

// =====> Segundo lightbox para AGREGAR REPORTE (Donde se ve el nino) <===
function showLightboxAddBodyHealthCkeck(
  temperature,
  report,
  fechaSeleccionada
) {
  console.log("Temperatura:", temperature);
  console.log("Reporte:", report);
  console.log("Fecha:", fechaSeleccionada);
  const contentContainer = document.createElement("div");
  contentContainer.classList.add("methods-addbodydaylihealth");
  const titleElement = document.getElementById("info-lightbox-title");
  const originalTextAlign = titleElement.style.textAlign;
  const originalmarginBottom = titleElement.style.marginBottom;
  titleElement.style.textAlign = "start";
  titleElement.style.marginBottom = "35px";

  const novedad = document.createElement("div");
  novedad.classList.add("nino");
  novedad.innerHTML = `
    <div class="nino-part">
      <p>¿En qué lugar ocurrió?</p>
      <div class="nino-cont">
        <div class="nino-container">
          <img src="img/info/Ninos_Health_Check_front.png" alt="Nino vista frontal">
          <img src="img/info/Ninos_Health_Check_tras.png" alt="Nino vista posterior">
          
          <!-- Círculos sobre las imágenes -->
          <div class="circle" data-area="Head" style="top: 0%; left: 19%;"></div>
          <div class="circle" data-area="Right_Eye" style="top: 21%; left: 15%;"></div>
          <div class="circle" data-area="Left_Eye" style="top: 21%; left: 22%;"></div>
          <div class="circle" data-area="Mouth" style="top: 32%; left: 19%;"></div>
          <div class="circle" data-area="Chest" style="top: 45%; left: 19%;"></div>
          <div class="circle" data-area="Stomach" style="top: 59%; left: 19%;"></div>
          <div class="circle" data-area="Left_Elbows" style="top: 49%; left: 28%;"></div>
          <div class="circle" data-area="Right_Elbows" style="top: 49%; left: 10%;"></div>
          <div class="circle" data-area="Left_Hands" style="top: 52%; left: 36%;"></div>
          <div class="circle" data-area="Right_Hands" style="top: 52%; left: 2%;"></div>
          <div class="circle" data-area="Left_Knee" style="top: 80%; left: 23%;"></div>
          <div class="circle" data-area="Right_Knee" style="top: 80%; left: 16%;"></div>
          <div class="circle" data-area="Left_Ankle" style="top: 93%; left: 23%;"></div>
          <div class="circle" data-area="Right_Ankle" style="top: 93%; left: 16%;"></div>
          <div class="circle" data-area="Back_Head" style="top: 0%; left: 81%;"></div>
          <div class="circle" data-area="Left_Ear" style="top: 25%; left: 72%;"></div>
          <div class="circle" data-area="Right_Ear" style="top: 25%; left: 91%;"></div>
          <div class="circle" data-area="Nape" style="top: 35%; left: 81%;"></div>
          <div class="circle" data-area="Left_Shoulder" style="top: 40%; left: 75%;"></div>
          <div class="circle" data-area="Right_Shoulder" style="top: 40%; left: 87%;"></div>
          <div class="circle" data-area="Left_Wrist" style="top: 52%; left: 68%;"></div>
          <div class="circle" data-area="Right_Wrist" style="top: 52%; left: 95%;"></div>
          <div class="circle" data-area="Left_Rib" style="top: 55%; left: 76%;"></div>
          <div class="circle" data-area="Right_Rib" style="top: 55%; left: 86%;"></div>
          <div class="circle" data-area="Back" style="top: 50%; left: 81%;"></div>
          <div class="circle" data-area="Left_Foot" style="top: 95%; left: 75%;"></div>
          <div class="circle" data-area="Right_Foot" style="top: 95%; left: 87%;"></div>
        </div>
      </div>
    </div>
  `;

  const partselect = document.createElement("div");
  partselect.classList.add("partselect");
  partselect.innerHTML = `
    <p class="text"> Parte seleccionada </p>
    <p class="text-indication"> --- </p>
  `;

  const databutton = document.createElement("div");
  databutton.classList.add("divbutton");
  databutton.innerHTML = `
    <div class="progress-indicator">
      
    </div>
    <button id="btnAgregar-reporte" class="btn btn-action-primary enfasis btn-big btn-disable" type="button" onclick="handleHelthCheckInfo('${temperature}', '${report}', '${fechaSeleccionada}')"> Ingresar </button>   
  `;
  // Esperar a que el botón se agregue al DOM antes de asignarle el evento
  setTimeout(() => {
    const circles = document.querySelectorAll(".circle");
    if (report === "Ninguno") {
      // Si el reporte es "Ninguno", marcar todos los círculos en verde
      circles.forEach((circle) => {
        circle.style.backgroundColor = "rgba(101, 192, 142, 0.5)";
        circle.style.border = "2px solid var(--secundario1)";
      });
      const textIndication = document.querySelector(
        ".partselect .text-indication"
      );
      if (textIndication) {
        textIndication.style.backgroundColor = "rgba(101, 192, 142, 0.5)";
        textIndication.style.color = "var(--secundario1)";
        textIndication.style.border = "2px solid var(--secundario1)";
        textIndication.textContent = "OK";
      }
      // Guardar directamente "0" en la info de salud
      if (!kidData.healthinfo) kidData.healthinfo = {};
      if (!kidData.healthinfo.healthcheck) kidData.healthinfo.healthcheck = {};
      kidData.healthinfo.healthcheck.bodychild = "0";
      console.log("Área seleccionada automáticamente: 0");
      // enviarCorreo();
    } else {
      // Si el reporte es diferente a "Ninguno", permitir selección normal
      circles.forEach((circle) => {
        circle.addEventListener("click", (event) => {
          const selectedArea = event.target.getAttribute("data-area");
          // Guardar el área seleccionada en kidData
          if (!kidData.healthinfo) kidData.healthinfo = {};
          if (!kidData.healthinfo.healthcheck)
            kidData.healthinfo.healthcheck = {};

          kidData.healthinfo.healthcheck.bodychild = selectedArea;
          console.log(
            "Área seleccionada:",
            kidData.healthinfo.healthcheck.bodychild
          );

          // Resaltar solo el círculo seleccionado
          circles.forEach((c) => c.classList.remove("selected"));
          event.target.classList.add("selected");
          // Actualizar el texto dinámicamente
          const textIndication = document.querySelector(
            ".partselect .text-indication"
          );
          if (textIndication) {
            const area = selectedArea.replace(/_/g, " "); // Opcional: reemplaza "_" por espacios
            textIndication.textContent = area;
          }
        });
      });
    }
  }, 0);

  contentContainer.appendChild(novedad);
  contentContainer.appendChild(partselect);
  contentContainer.appendChild(databutton);
  showInfoLightbox("Daily Health Check", contentContainer);

  const closeButton = document.getElementById("info-close-button");
  const closeHandler = () => {
    titleElement.style.textAlign = originalTextAlign;
    titleElement.style.marginBottom = originalmarginBottom;
    closeButton.removeEventListener("click", closeHandler);
  };
  closeButton.addEventListener("click", closeHandler);
}

// =====> Lightbox para VER REPORTE <===
function showLightboxViewHealthCkeck(fechaSeleccionada) {
  const contentContainer = document.createElement("div");
  contentContainer.classList.add("methods-viewdaylihealth");
  const contentViewdaily = document.createElement("div");
  contentViewdaily.classList.add("viewdayli");
  const titleElement = document.getElementById("info-lightbox-title");
  const originalTextAlign = titleElement.style.textAlign;
  const originalmarginBottom = titleElement.style.marginBottom;
  titleElement.style.textAlign = "start";
  titleElement.style.marginBottom = "35px";

  const resultado = kidData.healthinfo.healthcheck.find(
    (item) => item.daily_fecha === fechaSeleccionada
  );

  // Datos del niño
  const dataNino = document.createElement("div");
  dataNino.classList.add("dataninobod");

  if (resultado) {
    const [year, month, day] = resultado.daily_fecha.split("-").map(Number);
    const fecha = new Date(year, month - 1, day);
    const nombreMes = fecha.toLocaleDateString("es-ES", { month: "long" });
    const mesCapitalizado =
      nombreMes.charAt(0).toUpperCase() + nombreMes.slice(1);

    // Nuevo formato: "Febrero 04/2025"
    const fechaFormateada = `${mesCapitalizado} ${String(day).padStart(
      2,
      "0"
    )}/${year}`;

    dataNino.innerHTML = `
      <p class="dataninobod-date"> ${fechaFormateada} </p>
      <p> <span class="hs"><i class="acuarela acuarela-Salud"></i> Temperatura: </span> <span class="ex"><span class="inc"> ${resultado.temperature} </span>°F</span>  </p>
      <p> <span class="hs"><i class="acuarela acuarela-Salud"></i> Reporte: </span> <span class="inc"> ${resultado.report} </span> </p>
    `;
  }

  // Contenedor de imágenes y círculos
  const novedad = document.createElement("div");
  novedad.classList.add("nino");
  novedad.innerHTML = `
    <div class="nino-part">
      <div class="nino-container">
        <img src="img/info/Ninos_Health_Check_front.png" alt="Nino vista frontal">
        <img src="img/info/Ninos_Health_Check_tras.png" alt="Nino vista posterior">
        
        <!-- Círculos sobre las imágenes -->
        <div class="circle" data-area="Head" style="top: 0%; left: 24%;"></div>
        <div class="circle" data-area="Right_Eye" style="top: 21%; left: 19%;"></div>
        <div class="circle" data-area="Left_Eye" style="top: 21%; left: 28%;"></div>
        <div class="circle" data-area="Mouth" style="top: 32%; left: 24%;"></div>
        <div class="circle" data-area="Chest" style="top: 45%; left: 24%;"></div>
        <div class="circle" data-area="Stomach" style="top: 59%; left: 24%;"></div>
        <div class="circle" data-area="Left_Elbows" style="top: 48%; left: 35%;"></div>
        <div class="circle" data-area="Right_Elbows" style="top: 48%; left: 12%;"></div>
        <div class="circle" data-area="Left_Hands" style="top: 52%; left: 45%;"></div>
        <div class="circle" data-area="Right_Hands" style="top: 52%; left: 3%;"></div>
        <div class="circle" data-area="Left_Knee" style="top: 80%; left: 29%;"></div>
        <div class="circle" data-area="Right_Knee" style="top: 80%; left: 21%;"></div>
        <div class="circle" data-area="Left_Ankle" style="top: 93%; left: 29%;"></div>
        <div class="circle" data-area="Right_Ankle" style="top: 93%; left: 21%;"></div>
        <div class="circle" data-area="Back_Head" style="top: 0%; left: 76%;"></div>
        <div class="circle" data-area="Left_Ear" style="top: 25%; left: 65%;"></div>
        <div class="circle" data-area="Right_Ear" style="top: 25%; left: 87%;"></div>
        <div class="circle" data-area="Nape" style="top: 35%; left: 76%;"></div>
        <div class="circle" data-area="Left_Shoulder" style="top: 40%; left: 67%;"></div>
        <div class="circle" data-area="Right_Shoulder" style="top: 40%; left: 84%;"></div>
        <div class="circle" data-area="Left_Wrist" style="top: 52%; left: 59%;"></div>
        <div class="circle" data-area="Right_Wrist" style="top: 52%; left: 94%;"></div>
        <div class="circle" data-area="Left_Rib" style="top: 55%; left: 68%;"></div>
        <div class="circle" data-area="Right_Rib" style="top: 55%; left: 83%;"></div>
        <div class="circle" data-area="back" style="top: 50%; left: 76%;"></div>
        <div class="circle" data-area="Left_Foot" style="top: 95%; left: 67%;"></div>
        <div class="circle" data-area="Right_Foot" style="top: 95%; left: 84%;"></div>
      </div>
    </div>
  `;

  // Botones de descarga
  const downloadReport = document.createElement("div");
  downloadReport.classList.add("downloadreport");
  // downloadReport.innerHTML = `
  //   <p> <i class="acuarela acuarela-Excel"></i> </p>
  //   <p> <i class="acuarela acuarela-Pdf"></i> </p>
  // `;

  contentViewdaily.appendChild(dataNino);
  contentViewdaily.appendChild(novedad);
  contentContainer.appendChild(contentViewdaily);
  contentContainer.appendChild(downloadReport);
  showInfoLightbox("Health Check", contentContainer);

  //Modificar estilos del div (circle) recibido
  const areasAfectadas = resultado.bodychild
    .split(/[, ]+/)
    .map((area) => area.trim().toLowerCase());
  novedad.querySelectorAll(".circle").forEach((circle) => {
    const area = circle.getAttribute("data-area").toLowerCase(); // Obtener el área en minúsculas
    if (resultado.bodychild === "0") {
      // Si bodychild es "0", mostrar todos en verde
      circle.style.backgroundColor = "rgba(101, 192, 142, 0.5)";
      circle.style.border = "2px solid var(--secundario1)";
      circle.style.display = "block"; // Asegurar que todos sean visibles
    } else if (areasAfectadas.includes(area)) {
      // Si el área está afectada, aplicamos los estilos de "rojo"
      circle.style.backgroundColor = "rgba(235, 93, 94, 0.8)";
      circle.style.boxShadow = "0 0 15px rgba(235, 93, 94, 0.5)";
      circle.classList.add("animate");
      circle.style.display = "block"; // Asegurar que el afectado sea visible
    } else {
      // Si el área NO está afectada, ocultarla
      circle.style.display = "none";
    }
  });

  const closeButton = document.getElementById("info-close-button");
  const closeHandler = () => {
    titleElement.style.textAlign = originalTextAlign;
    titleElement.style.marginBottom = originalmarginBottom;
    closeButton.removeEventListener("click", closeHandler);
  };
  closeButton.addEventListener("click", closeHandler);
}

// =====> Lightbox para AGREGAR REPORTE en el HealthCheck (grupo.php) <===
function showLightboxNinoHealthCkeck() {
  const contentContainer = document.createElement("div");
  contentContainer.classList.add("methods-daylihealth");

  const titleElement = document.getElementById("info-lightbox-title");
  const originalTextAlign = titleElement.style.textAlign;
  const originalMarginBottom = titleElement.style.marginBottom;
  titleElement.style.textAlign = "start";
  titleElement.style.marginBottom = "35px";

  const children = groupData.children;

  // Parte deslizante de los niños
  const ninosdailyhealth = document.createElement("div");
  ninosdailyhealth.classList.add("ninosdaily");

  const iconoFlechaIzq = document.createElement("i");
  iconoFlechaIzq.classList.add(
    "ninosflecha",
    "acuarela",
    "acuarela-Flecha_circ_izquierda"
  );
  ninosdailyhealth.appendChild(iconoFlechaIzq);

  const container = document.createElement("div");
  container.classList.add("ninosdaily-container");
  const wrapper = document.createElement("div");
  wrapper.classList.add("ninosdaily-wrapper");

  let selectedKid = null; // Variable para almacenar el niño seleccionado
  children.forEach((kid) => {
    console.log("kid: ", kid);
    const li = document.createElement("div");
    li.classList.add("ninos_slide");
    li.dataset.kidId = kid.id; // Guarda el ID del niño en el dataset
    li.dataset.kidName = kid.name; // Guarda el nombre (opcional para depuración)

    let photoUrl = kid.photo
      ? `https://acuarelacore.com/api/${kid.photo.formats.small.url}`
      : null;
    let gender = kid.gender;

    li.innerHTML = `
      <div class="photo">
        ${photoUrl
        ? `<img class="img-infonino" src="${photoUrl}" alt="${kid.name}">`
        : `${gender === "Masculino"
          ? '<img class="img-infonino" src="img/mal.png" alt="">'
          : ""
        }
           ${gender === "Femenino"
          ? '<img class="img-infonino" src="img/fem.png" alt="">'
          : ""
        }
           ${gender === "X"
          ? '<img class="img-infonino" src="img/Nonbinary.png" alt="">'
          : ""
        }`
      }
      </div>
      <span>${kid.name}</span>
    `;
    wrapper.appendChild(li);
  });
  container.appendChild(wrapper);
  ninosdailyhealth.appendChild(container);
  const iconoFlechaDer = document.createElement("i");
  iconoFlechaDer.classList.add(
    "ninosflecha",
    "acuarela",
    "acuarela-Flecha_circ_derecha"
  );
  ninosdailyhealth.appendChild(iconoFlechaDer);

  // Boton para pasar al siguiente lightbox
  const databutton = document.createElement("div");
  databutton.classList.add("divbutton");
  databutton.innerHTML = `
    <div class="progress-indicator">
    
    </div>
    <button id="btnSiguiente" class="btn btn-action-primary enfasis btn-big btn-disable"> Siguiente </button>   
  `;

  contentContainer.appendChild(ninosdailyhealth);
  contentContainer.appendChild(databutton);

  showInfoLightbox("Daily Health Check", contentContainer);

  // Selección de un niño y activación del botón
  const btnSiguiente = document.getElementById("btnSiguiente");
  wrapper.querySelectorAll(".ninos_slide").forEach((nino) => {
    nino.addEventListener("click", () => {
      // Quitar la clase 'selected' de todos los elementos
      wrapper
        .querySelectorAll(".ninos_slide")
        .forEach((el) => el.classList.remove("selected"));

      // Agregar la clase 'selected' al niño seleccionado
      nino.classList.add("selected");

      // Activar el botón
      btnSiguiente.classList.remove("btn-disable");
      btnSiguiente.style.backgroundColor = "var(--cielo)";
      btnSiguiente.disabled = false;

      // Obtener el ID del niño desde el dataset
      const selectedKidId = nino.dataset.kidId;
      selectedKid = children.find((kid) => kid.id === selectedKidId); // Buscar el niño en la lista original

      // Mostrar en consola
      console.log("Niño seleccionado:", selectedKid);
      console.log("ID del niño seleccionado:", selectedKid?.id);
    });
  });
  const fechaselec = "null";
  console.log("Fecha:", fechaselec);
  btnSiguiente.addEventListener("click", () => {
    if (selectedKid) {
      console.log(
        "ID del niño seleccionado al hacer clic en 'Siguiente':",
        selectedKid.id
      );
      // showLightboxAddHealthCkeck(fechaselec, 1, selectedKid);
    } else {
      console.log("No se ha seleccionado ningún niño.");
    }
  });

  // Control deslizante
  let index = 0;
  const maxIndex = children.length - 4; // Máximo número de deslizamientos
  const slideWidth = 99; // Ancho de cada slide + margen (ajustar si es necesario)

  function moveSlides(direction) {
    if (direction === "left" && index > 0) {
      index--;
    } else if (direction === "right" && index < maxIndex) {
      index++;
    }
    wrapper.style.transform = `translateX(-${index * slideWidth}px)`;
  }
  iconoFlechaIzq.addEventListener("click", () => moveSlides("left"));
  iconoFlechaDer.addEventListener("click", () => moveSlides("right"));

  const closeButton = document.getElementById("info-close-button");
  const closeHandler = () => {
    titleElement.style.textAlign = originalTextAlign;
    titleElement.style.marginBottom = originalMarginBottom;
    closeButton.removeEventListener("click", closeHandler);
  };
  closeButton.addEventListener("click", closeHandler);
}

// // Función que se ejecuta si el ID es diferente del objetivo (para mostrar el lightbox)
// function showLightboxParient() {
//   const contentContainer = document.createElement("div");
//   contentContainer.classList.add("methods-emergency");

//   const linkGrave = document.createElement("a");
//   linkGrave.classList.add("emergency");
//   linkGrave.innerHTML = `
//     <img src="img/icons/ambossandia.svg"" alt="file">
//     <span>Caso grave </span>
//   `;

//   const linkModerado = document.createElement("a");
//   linkModerado.classList.add("emergency");
//   linkModerado.innerHTML = `
//     <img src="img/icons/ambospollito.svg"" alt="file">
//     <span>Caso leve o moderado </span>
//   `;

//   contentContainer.appendChild(linkGrave);
//   contentContainer.appendChild(linkModerado);

//   showInfoLightbox(
//     "Contactar con pariente según nivel de gravedad",
//     contentContainer
//   );
// }

const getDataAsistentes = async () => {
  const response = await fetch(`g/getAsistentes/`);
  const asistentes = await response.json();
  return asistentes;
};
const getAsistentes = async () => {
  if (document.querySelector(".asistentesList")) {
    const container = document.querySelector(".asistentes-list");
    let asistentes = await getDataAsistentes();
    if (asistentes.length > 0) {
      const createAsistenteTemplate = (asistente, iconClass) => `
        
      <div class="options">
        <i class="acuarela acuarela-Opciones"></i>
        <ul>
          <li>
            <button type="button" id="eliminar" onclick='showLightbox("Eliminar asistente","¿Estás seguro de que quieres eliminar esta asistente?","acuarelausers","${asistente.id
        }");'>Eliminar</button>
          </li>
        </ul>
      </div>
         <a href="/miembros/acuarela-app-web/asistente/${asistente.id}" >
          <div class="image">
            ${asistente.photo
          ? `<img src='${getSmallestImageUrl(asistente.photo)}' alt='${asistente.name
          }'>`
          : `<img src="img/placeholder.png" alt="placeholder">`
        }
            <i class="acuarela ${iconClass}"></i>
          </div>
          <span class="name">${asistente.name}</span>
         </a>
       `;
      const renderAsistentes = (asistentesArray, container, iconClass) => {
        const fragment = document.createDocumentFragment();
        asistentesArray.forEach((kid) => {
          const template = createAsistenteTemplate(kid, iconClass);
          const listItem = document.createElement("li");
          listItem.innerHTML = template;
          fragment.appendChild(listItem);
        });
        container.appendChild(fragment);
      };
      renderAsistentes(asistentes, container, "acuarela-Aceptar");
    } else {
      document.querySelector(".emptyElement").style.display = "flex";
    }
    fadeOut(preloader);
  }
};
let icono1 = `<svg width="40" height="33" viewBox="0 0 40 33" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_99_39679)"><path d="M36.6687 7.2371L36.6497 7.24281C35.9629 7.42735 35.5558 8.13317 35.7403 8.81998L35.8773 9.26706C35.9096 9.3717 35.786 9.45351 35.7022 9.38502L35.3788 9.11867C35.3103 9.06159 35.2437 9.00262 35.1772 8.94364C34.7415 8.56124 34.1764 8.3044 33.6742 8.17313L33.6666 8.17123C33.1301 8.01712 32.5251 8.02854 31.8725 8.20357C31.511 8.30059 31.1743 8.42997 30.8699 8.58978L30.5351 8.76671L28.8038 2.30392C28.5869 1.49727 27.7574 1.01784 26.9508 1.23472L18.4085 3.52152L18.4827 3.17717C18.517 3.01356 18.5341 2.84423 18.5303 2.67301C18.5246 2.44661 18.4904 2.2107 18.4257 1.97099C18.2202 1.20618 17.8226 0.665874 17.2119 0.321522C16.5974 -0.0247325 15.9144 -0.0913199 15.1248 0.12176C14.849 0.195957 14.6017 0.291082 14.3867 0.407134C14.1736 0.521284 13.9814 0.658264 13.8159 0.810464C13.6523 0.960761 13.5096 1.13769 13.3936 1.33746C13.0302 1.93294 12.9541 2.5931 13.1596 3.36171C13.2128 3.55957 13.2946 3.76504 13.405 3.97432C13.5058 4.13413 13.6257 4.29203 13.7626 4.44804L13.9909 4.70678L5.41069 7.00309C4.60403 7.21998 4.1246 8.04947 4.34149 8.85612L7.629 21.1272C7.58524 21.2224 7.53768 21.3156 7.48441 21.4069C7.31889 21.6904 7.11152 21.9472 6.86229 22.1622C6.60926 22.3696 6.32579 22.5142 6.01568 22.5979C5.35742 22.7748 4.78857 22.7063 4.30724 22.3943C3.8183 22.0975 3.48156 21.6067 3.29892 20.9256C3.10867 20.214 3.09155 19.6281 3.2894 19.0954C3.40546 18.7872 3.62615 18.399 3.8963 18.3077C4.09226 18.243 4.31485 18.2107 4.52413 18.2221C5.30795 18.2678 5.17288 17.307 4.97121 16.8257C4.85516 16.546 4.5051 16.0723 4.13031 15.9144C3.93816 15.8326 3.3617 15.7356 2.76051 16.0038C1.5372 16.5498 1.04826 17.2366 0.593566 17.9976C-0.0589901 19.0916 -0.156017 20.3643 0.220677 21.7684C0.351949 22.2554 0.521271 22.693 0.726741 23.0792C0.934113 23.4654 1.17763 23.8098 1.4573 24.1122C1.73697 24.4147 2.06039 24.6754 2.42757 24.8923C3.50439 25.5486 4.72959 25.6932 6.1051 25.3241C6.47038 25.2271 6.84137 25.0768 7.22187 24.8732C7.48061 24.7096 7.73364 24.5251 7.97716 24.3177C8.14077 24.1788 8.25302 24.0114 8.35385 23.8326L10.1137 30.3981C10.3305 31.2048 11.16 31.6842 11.9667 31.4673L20.5736 29.1615L20.4709 29.6447C20.4366 29.8083 20.4195 29.9776 20.4233 30.1489C20.429 30.3753 20.4632 30.6112 20.5279 30.8509C20.7334 31.6157 21.131 32.156 21.7417 32.5004C22.3562 32.8466 23.0392 32.9132 23.8269 32.7001C24.1027 32.6259 24.35 32.5308 24.565 32.4147C24.7781 32.3006 24.9703 32.1636 25.1358 32.0114C25.2994 31.8611 25.4421 31.6842 25.5581 31.4844C25.9215 30.8889 25.9976 30.2288 25.7921 29.4602C25.7389 29.2623 25.6571 29.0568 25.5467 28.8476C25.4459 28.6878 25.326 28.5298 25.189 28.3738L24.8675 28.0086L33.5087 25.6932C34.3153 25.4763 34.7948 24.6468 34.5779 23.8402L33.0026 17.9596L33.3698 17.9348C33.6437 17.9158 33.9272 17.8683 34.2145 17.7922C34.8899 17.6114 35.4473 17.3108 35.8716 16.8961C36.2977 16.4794 36.585 15.9734 36.9636 15.3208L37.2033 14.8947C37.249 14.8128 37.3726 14.8281 37.3974 14.9194L37.4602 15.1534C37.6428 15.8383 38.3372 16.2816 39.024 16.1103C39.7241 15.9372 40.1427 15.2219 39.9581 14.5275L38.2478 8.14269C38.0613 7.46159 37.3555 7.05256 36.6687 7.2371ZM13.4735 11.4911C13.7075 10.9584 14.1603 10.5646 14.7215 10.4143C15.2827 10.264 15.8896 10.3553 16.3405 10.7225C16.5726 10.9127 16.6145 11.3826 16.5003 11.5348C16.4528 11.5995 16.3862 11.6433 16.3139 11.6623C16.2169 11.6889 16.1084 11.6718 16.0209 11.6071C15.7222 11.3864 15.3455 11.3141 14.9879 11.4112C14.6302 11.5063 14.3391 11.7574 14.1907 12.098C14.1146 12.2711 13.9129 12.351 13.7398 12.2749C13.5667 12.2007 13.3384 11.7993 13.4735 11.4911ZM24.3063 15.3684C24.5783 16.3862 24.7001 17.1472 24.6716 17.6514C24.6354 18.1784 24.4756 18.6863 24.1921 19.1791C23.9258 19.6661 23.5168 20.0904 22.965 20.4537C22.4399 20.8019 21.7741 21.0854 20.9617 21.3023C20.1569 21.5172 19.4454 21.6048 18.829 21.561C18.1974 21.5287 17.619 21.3688 17.0939 21.0816C16.6145 20.819 16.2283 20.4633 15.9372 20.0124C15.6556 19.5957 15.376 18.8709 15.0982 17.8359L14.2801 14.7862C14.0575 13.9586 14.5503 13.1082 15.3779 12.8856C16.2055 12.663 17.0559 13.1558 17.2785 13.9834L18.1498 17.2366C18.3496 17.9824 18.6197 18.4847 18.9584 18.7396C19.2799 19.0193 19.7213 19.0839 20.2863 18.9317C20.8456 18.7815 21.2014 18.5094 21.3574 18.1156C21.5134 17.7218 21.4906 17.1472 21.2889 16.3957L20.4176 13.1425C20.195 12.3149 20.6877 11.4644 21.5153 11.2419L21.5857 11.2228C22.4133 11.0002 23.2637 11.493 23.4863 12.3206L24.3063 15.3684ZM22.7063 9.87396C22.6587 9.93865 22.5921 9.9824 22.5198 10.0014C22.4228 10.0281 22.3144 10.0109 22.2269 9.94625C21.9282 9.72556 21.5515 9.65327 21.1938 9.7503L21.1234 9.76932C20.7657 9.86445 20.4747 10.1156 20.3263 10.4561C20.2502 10.6293 20.0485 10.7092 19.8754 10.6331C19.7022 10.557 19.5044 10.1688 19.609 9.84923C19.7879 9.2956 20.2958 8.92271 20.8571 8.77241L20.9275 8.75339C21.4887 8.60309 22.0651 8.73436 22.5465 9.06159C22.8319 9.25565 22.8185 9.72176 22.7063 9.87396ZM35.7707 13.97C35.5063 14.4571 35.0611 14.7843 34.4352 14.9517C33.8036 15.121 33.2594 15.0583 32.8009 14.7653C32.3234 14.4704 31.9943 13.9776 31.8078 13.2889C31.6252 12.604 31.6632 12.0105 31.9258 11.5044C32.1788 11.0136 32.6202 10.6844 33.2461 10.517C33.872 10.3496 34.4257 10.4181 34.9051 10.7244C35.3731 11.0098 35.7003 11.4987 35.8868 12.195C36.0751 12.8913 36.0352 13.483 35.7707 13.97Z" fill="#0CB5C3" /></g><defs><clipPath id="clip0_99_39679"><rect width="40" height="32.8219" fill="white" /></clipPath></defs></svg>`;
let icono2 = `<svg width="40" height="33" viewBox="0 0 40 33" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_99_39689)"><path d="M36.6687 7.2371L36.6497 7.24281C35.9629 7.42735 35.5558 8.13317 35.7403 8.81998L35.8773 9.26706C35.9096 9.3717 35.786 9.45351 35.7022 9.38502L35.3788 9.11867C35.3103 9.06159 35.2437 9.00262 35.1772 8.94364C34.7415 8.56124 34.1764 8.3044 33.6742 8.17313L33.6666 8.17123C33.1301 8.01712 32.5251 8.02854 31.8725 8.20357C31.511 8.30059 31.1743 8.42997 30.8699 8.58978L30.5351 8.76671L28.8038 2.30392C28.5869 1.49727 27.7574 1.01784 26.9508 1.23472L18.4085 3.52152L18.4827 3.17717C18.517 3.01356 18.5341 2.84423 18.5303 2.67301C18.5246 2.44661 18.4904 2.2107 18.4257 1.97099C18.2202 1.20618 17.8226 0.665874 17.2119 0.321522C16.5974 -0.0247325 15.9144 -0.0913199 15.1248 0.12176C14.849 0.195957 14.6017 0.291082 14.3867 0.407134C14.1736 0.521284 13.9814 0.658264 13.8159 0.810464C13.6523 0.960761 13.5096 1.13769 13.3936 1.33746C13.0302 1.93294 12.9541 2.5931 13.1596 3.36171C13.2128 3.55957 13.2946 3.76504 13.405 3.97432C13.5058 4.13413 13.6257 4.29203 13.7626 4.44804L13.9909 4.70678L5.41069 7.00309C4.60403 7.21998 4.1246 8.04947 4.34149 8.85612L7.629 21.1272C7.58524 21.2224 7.53768 21.3156 7.48441 21.4069C7.31889 21.6904 7.11152 21.9472 6.86229 22.1622C6.60926 22.3696 6.32579 22.5142 6.01568 22.5979C5.35742 22.7748 4.78857 22.7063 4.30724 22.3943C3.8183 22.0975 3.48156 21.6067 3.29892 20.9256C3.10867 20.214 3.09155 19.6281 3.2894 19.0954C3.40546 18.7872 3.62615 18.399 3.8963 18.3077C4.09226 18.243 4.31485 18.2107 4.52413 18.2221C5.30795 18.2678 5.17288 17.307 4.97121 16.8257C4.85516 16.546 4.5051 16.0723 4.13031 15.9144C3.93816 15.8326 3.3617 15.7356 2.76051 16.0038C1.5372 16.5498 1.04826 17.2366 0.593566 17.9976C-0.0589901 19.0916 -0.156017 20.3643 0.220677 21.7684C0.351949 22.2554 0.521271 22.693 0.726741 23.0792C0.934113 23.4654 1.17763 23.8098 1.4573 24.1122C1.73697 24.4147 2.06039 24.6754 2.42757 24.8923C3.50439 25.5486 4.72959 25.6932 6.1051 25.3241C6.47038 25.2271 6.84137 25.0768 7.22187 24.8732C7.48061 24.7096 7.73364 24.5251 7.97716 24.3177C8.14077 24.1788 8.25302 24.0114 8.35385 23.8326L10.1137 30.3981C10.3305 31.2048 11.16 31.6842 11.9667 31.4673L20.5736 29.1615L20.4709 29.6447C20.4366 29.8083 20.4195 29.9776 20.4233 30.1489C20.429 30.3753 20.4632 30.6112 20.5279 30.8509C20.7334 31.6157 21.131 32.156 21.7417 32.5004C22.3562 32.8466 23.0392 32.9132 23.8269 32.7001C24.1027 32.6259 24.35 32.5308 24.565 32.4147C24.7781 32.3006 24.9703 32.1636 25.1358 32.0114C25.2994 31.8611 25.4421 31.6842 25.5581 31.4844C25.9215 30.8889 25.9976 30.2288 25.7921 29.4602C25.7389 29.2623 25.6571 29.0568 25.5467 28.8476C25.4459 28.6878 25.326 28.5298 25.189 28.3738L24.8675 28.0086L33.5087 25.6932C34.3153 25.4763 34.7948 24.6468 34.5779 23.8402L33.0026 17.9596L33.3698 17.9348C33.6437 17.9158 33.9272 17.8683 34.2145 17.7922C34.8899 17.6114 35.4473 17.3108 35.8716 16.8961C36.2977 16.4794 36.585 15.9734 36.9636 15.3208L37.2033 14.8947C37.249 14.8128 37.3726 14.8281 37.3974 14.9194L37.4602 15.1534C37.6428 15.8383 38.3372 16.2816 39.024 16.1103C39.7241 15.9372 40.1427 15.2219 39.9581 14.5275L38.2478 8.14269C38.0613 7.46159 37.3555 7.05256 36.6687 7.2371ZM13.4735 11.4911C13.7075 10.9584 14.1603 10.5646 14.7215 10.4143C15.2827 10.264 15.8896 10.3553 16.3405 10.7225C16.5726 10.9127 16.6145 11.3826 16.5003 11.5348C16.4528 11.5995 16.3862 11.6433 16.3139 11.6623C16.2169 11.6889 16.1084 11.6718 16.0209 11.6071C15.7222 11.3864 15.3455 11.3141 14.9879 11.4112C14.6302 11.5063 14.3391 11.7574 14.1907 12.098C14.1146 12.2711 13.9129 12.351 13.7398 12.2749C13.5667 12.2007 13.3384 11.7993 13.4735 11.4911ZM24.3063 15.3684C24.5783 16.3862 24.7001 17.1472 24.6716 17.6514C24.6354 18.1784 24.4756 18.6863 24.1921 19.1791C23.9258 19.6661 23.5168 20.0904 22.965 20.4537C22.4399 20.8019 21.7741 21.0854 20.9617 21.3023C20.1569 21.5172 19.4454 21.6048 18.829 21.561C18.1974 21.5287 17.619 21.3688 17.0939 21.0816C16.6145 20.819 16.2283 20.4633 15.9372 20.0124C15.6556 19.5957 15.376 18.8709 15.0982 17.8359L14.2801 14.7862C14.0575 13.9586 14.5503 13.1082 15.3779 12.8856C16.2055 12.663 17.0559 13.1558 17.2785 13.9834L18.1498 17.2366C18.3496 17.9824 18.6197 18.4847 18.9584 18.7396C19.2799 19.0193 19.7213 19.0839 20.2863 18.9317C20.8456 18.7815 21.2014 18.5094 21.3574 18.1156C21.5134 17.7218 21.4906 17.1472 21.2889 16.3957L20.4176 13.1425C20.195 12.3149 20.6877 11.4644 21.5153 11.2419L21.5857 11.2228C22.4133 11.0002 23.2637 11.493 23.4863 12.3206L24.3063 15.3684ZM22.7063 9.87396C22.6587 9.93865 22.5921 9.9824 22.5198 10.0014C22.4228 10.0281 22.3144 10.0109 22.2269 9.94625C21.9282 9.72556 21.5515 9.65327 21.1938 9.7503L21.1234 9.76932C20.7657 9.86445 20.4747 10.1156 20.3263 10.4561C20.2502 10.6293 20.0485 10.7092 19.8754 10.6331C19.7022 10.557 19.5044 10.1688 19.609 9.84923C19.7879 9.2956 20.2958 8.92271 20.8571 8.77241L20.9275 8.75339C21.4887 8.60309 22.0651 8.73436 22.5465 9.06159C22.8319 9.25565 22.8185 9.72176 22.7063 9.87396ZM35.7707 13.97C35.5063 14.4571 35.0611 14.7843 34.4352 14.9517C33.8036 15.121 33.2594 15.0583 32.8009 14.7653C32.3234 14.4704 31.9943 13.9776 31.8078 13.2889C31.6252 12.604 31.6632 12.0105 31.9258 11.5044C32.1788 11.0136 32.6202 10.6844 33.2461 10.517C33.872 10.3496 34.4257 10.4181 34.9051 10.7244C35.3731 11.0098 35.7003 11.4987 35.8868 12.195C36.0751 12.8913 36.0352 13.483 35.7707 13.97Z" fill="#F5AA16" /></g><defs><clipPath id="clip0_99_39689"><rect width="40" height="32.8219" fill="white" /></clipPath></defs></svg>`;
let icono3 = `<svg width="40" height="33" viewBox="0 0 40 33" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_99_39691)"><path d="M36.6687 7.2371L36.6497 7.24281C35.9629 7.42735 35.5558 8.13317 35.7403 8.81998L35.8773 9.26706C35.9096 9.3717 35.786 9.45351 35.7022 9.38502L35.3788 9.11867C35.3103 9.06159 35.2437 9.00262 35.1772 8.94364C34.7415 8.56124 34.1764 8.3044 33.6742 8.17313L33.6666 8.17123C33.1301 8.01712 32.5251 8.02854 31.8725 8.20357C31.511 8.30059 31.1743 8.42997 30.8699 8.58978L30.5351 8.76671L28.8038 2.30392C28.5869 1.49727 27.7574 1.01784 26.9508 1.23472L18.4085 3.52152L18.4827 3.17717C18.517 3.01356 18.5341 2.84423 18.5303 2.67301C18.5246 2.44661 18.4904 2.2107 18.4257 1.97099C18.2202 1.20618 17.8226 0.665874 17.2119 0.321522C16.5974 -0.0247325 15.9144 -0.0913199 15.1248 0.12176C14.849 0.195957 14.6017 0.291082 14.3867 0.407134C14.1736 0.521284 13.9814 0.658264 13.8159 0.810464C13.6523 0.960761 13.5096 1.13769 13.3936 1.33746C13.0302 1.93294 12.9541 2.5931 13.1596 3.36171C13.2128 3.55957 13.2946 3.76504 13.405 3.97432C13.5058 4.13413 13.6257 4.29203 13.7626 4.44804L13.9909 4.70678L5.41069 7.00309C4.60403 7.21998 4.1246 8.04947 4.34149 8.85612L7.629 21.1272C7.58524 21.2224 7.53768 21.3156 7.48441 21.4069C7.31889 21.6904 7.11152 21.9472 6.86229 22.1622C6.60926 22.3696 6.32579 22.5142 6.01568 22.5979C5.35742 22.7748 4.78857 22.7063 4.30724 22.3943C3.8183 22.0975 3.48156 21.6067 3.29892 20.9256C3.10867 20.214 3.09155 19.6281 3.2894 19.0954C3.40546 18.7872 3.62615 18.399 3.8963 18.3077C4.09226 18.243 4.31485 18.2107 4.52413 18.2221C5.30795 18.2678 5.17288 17.307 4.97121 16.8257C4.85516 16.546 4.5051 16.0723 4.13031 15.9144C3.93816 15.8326 3.3617 15.7356 2.76051 16.0038C1.5372 16.5498 1.04826 17.2366 0.593566 17.9976C-0.0589901 19.0916 -0.156017 20.3643 0.220677 21.7684C0.351949 22.2554 0.521271 22.693 0.726741 23.0792C0.934113 23.4654 1.17763 23.8098 1.4573 24.1122C1.73697 24.4147 2.06039 24.6754 2.42757 24.8923C3.50439 25.5486 4.72959 25.6932 6.1051 25.3241C6.47038 25.2271 6.84137 25.0768 7.22187 24.8732C7.48061 24.7096 7.73364 24.5251 7.97716 24.3177C8.14077 24.1788 8.25302 24.0114 8.35385 23.8326L10.1137 30.3981C10.3305 31.2048 11.16 31.6842 11.9667 31.4673L20.5736 29.1615L20.4709 29.6447C20.4366 29.8083 20.4195 29.9776 20.4233 30.1489C20.429 30.3753 20.4632 30.6112 20.5279 30.8509C20.7334 31.6157 21.131 32.156 21.7417 32.5004C22.3562 32.8466 23.0392 32.9132 23.8269 32.7001C24.1027 32.6259 24.35 32.5308 24.565 32.4147C24.7781 32.3006 24.9703 32.1636 25.1358 32.0114C25.2994 31.8611 25.4421 31.6842 25.5581 31.4844C25.9215 30.8889 25.9976 30.2288 25.7921 29.4602C25.7389 29.2623 25.6571 29.0568 25.5467 28.8476C25.4459 28.6878 25.326 28.5298 25.189 28.3738L24.8675 28.0086L33.5087 25.6932C34.3153 25.4763 34.7948 24.6468 34.5779 23.8402L33.0026 17.9596L33.3698 17.9348C33.6437 17.9158 33.9272 17.8683 34.2145 17.7922C34.8899 17.6114 35.4473 17.3108 35.8716 16.8961C36.2977 16.4794 36.585 15.9734 36.9636 15.3208L37.2033 14.8947C37.249 14.8128 37.3726 14.8281 37.3974 14.9194L37.4602 15.1534C37.6428 15.8383 38.3372 16.2816 39.024 16.1103C39.7241 15.9372 40.1427 15.2219 39.9581 14.5275L38.2478 8.14269C38.0613 7.46159 37.3555 7.05256 36.6687 7.2371ZM13.4735 11.4911C13.7075 10.9584 14.1603 10.5646 14.7215 10.4143C15.2827 10.264 15.8896 10.3553 16.3405 10.7225C16.5726 10.9127 16.6145 11.3826 16.5003 11.5348C16.4528 11.5995 16.3862 11.6433 16.3139 11.6623C16.2169 11.6889 16.1084 11.6718 16.0209 11.6071C15.7222 11.3864 15.3455 11.3141 14.9879 11.4112C14.6302 11.5063 14.3391 11.7574 14.1907 12.098C14.1146 12.2711 13.9129 12.351 13.7398 12.2749C13.5667 12.2007 13.3384 11.7993 13.4735 11.4911ZM24.3063 15.3684C24.5783 16.3862 24.7001 17.1472 24.6716 17.6514C24.6354 18.1784 24.4756 18.6863 24.1921 19.1791C23.9258 19.6661 23.5168 20.0904 22.965 20.4537C22.4399 20.8019 21.7741 21.0854 20.9617 21.3023C20.1569 21.5172 19.4454 21.6048 18.829 21.561C18.1974 21.5287 17.619 21.3688 17.0939 21.0816C16.6145 20.819 16.2283 20.4633 15.9372 20.0124C15.6556 19.5957 15.376 18.8709 15.0982 17.8359L14.2801 14.7862C14.0575 13.9586 14.5503 13.1082 15.3779 12.8856C16.2055 12.663 17.0559 13.1558 17.2785 13.9834L18.1498 17.2366C18.3496 17.9824 18.6197 18.4847 18.9584 18.7396C19.2799 19.0193 19.7213 19.0839 20.2863 18.9317C20.8456 18.7815 21.2014 18.5094 21.3574 18.1156C21.5134 17.7218 21.4906 17.1472 21.2889 16.3957L20.4176 13.1425C20.195 12.3149 20.6877 11.4644 21.5153 11.2419L21.5857 11.2228C22.4133 11.0002 23.2637 11.493 23.4863 12.3206L24.3063 15.3684ZM22.7063 9.87396C22.6587 9.93865 22.5921 9.9824 22.5198 10.0014C22.4228 10.0281 22.3144 10.0109 22.2269 9.94625C21.9282 9.72556 21.5515 9.65327 21.1938 9.7503L21.1234 9.76932C20.7657 9.86445 20.4747 10.1156 20.3263 10.4561C20.2502 10.6293 20.0485 10.7092 19.8754 10.6331C19.7022 10.557 19.5044 10.1688 19.609 9.84923C19.7879 9.2956 20.2958 8.92271 20.8571 8.77241L20.9275 8.75339C21.4887 8.60309 22.0651 8.73436 22.5465 9.06159C22.8319 9.25565 22.8185 9.72176 22.7063 9.87396ZM35.7707 13.97C35.5063 14.4571 35.0611 14.7843 34.4352 14.9517C33.8036 15.121 33.2594 15.0583 32.8009 14.7653C32.3234 14.4704 31.9943 13.9776 31.8078 13.2889C31.6252 12.604 31.6632 12.0105 31.9258 11.5044C32.1788 11.0136 32.6202 10.6844 33.2461 10.517C33.872 10.3496 34.4257 10.4181 34.9051 10.7244C35.3731 11.0098 35.7003 11.4987 35.8868 12.195C36.0751 12.8913 36.0352 13.483 35.7707 13.97Z" fill="#EB5D5E" /></g><defs><clipPath id="clip0_99_39691"><rect width="40" height="32.8219" fill="white" /></clipPath></defs></svg>`;
const getGrupos = async () => {
  if (document.querySelector(".grupos")) {
    const container = document.querySelector(".grupos .list");
    const response = await fetch(`g/getGrupos/`);
    const grupos = await response.json();

    // Objeto que mapea los tipos de actividad con los íconos correspondientes
    const activityIcons = [icono1, icono2, icono3];
    if (grupos.length == 3) {
      document.querySelector(".alertMessage").style.display = "flex";
      document.querySelector(".mainHeader .actions a").style.display = "none";
    }
    if (grupos.length == 0) {
      document.querySelector(".emptyElement").style.display = "flex";
    }
    grupos.forEach((grupo) => {
      let { name, age_range, shift, rates, acuarelauser, id } = grupo;
      let acuarelaUserName = null;
      if (acuarelauser) {
        acuarelaUserName = acuarelauser.name;
      }
      // Genera el template para cada grupo
      let template = `<li>
      <div class="options">
            <i class="acuarela acuarela-Opciones"></i>
            <ul>
              <li>
                <button type="button" id="eliminar" onclick='showLightbox("Eliminar grupo","¿Estás seguro de que quieres eliminar esta grupo?","groups","${id}");'>Eliminar</button>
              </li>
            </ul>
          </div>
      <a href="/miembros/acuarela-app-web/grupo/${id}">
        <div class="groupInfo">
          <h3>${name}</h3>
          <p>Líder del grupo: ${acuarelaUserName}</p>
          <p>${age_range}</p>
          <p>${shift}</p>
        </div>
        <ul class="rate">`;

      // Itera sobre las tasas (rates) del grupo y agrega cada tipo de actividad con su icono
      rates.forEach((rate) => {
        let iconClass = activityIcons[rate.rate];
        if (iconClass) {
          template += `<li>
            ${iconClass}
              <span> ${rate.name}</span>
          </li>`;
        }
      });

      template += `</ul></a></li>`;
      container.innerHTML += template;
    });
    fadeOut(preloader);
  }
};

// Validación Global COPPA para checkboxes de selección
window.validateCoppaSelection = (event, status) => {
  if (status && status !== 'granted') {
    event.preventDefault();
    event.stopPropagation();
    let msg = "No se puede seleccionar este niño porque el consentimiento COPPA está pendiente de aprobación.";
    if (status === 'revoked') msg = "No se puede seleccionar este niño porque el consentimiento COPPA ha sido revocado.";

    if (typeof Swal !== 'undefined') {
      Swal.fire({
        title: 'Acción Restringida',
        text: msg,
        icon: 'warning',
        confirmButtonColor: '#0cb5c3'
      });
    } else {
      alert(msg);
    }
    return false;
  }
};

const getInfoNewGroup = () => {
  if (document.querySelector(".newgroup")) {
    fetchAllUrls(["g/getAsistentes/", "g/getAgeGroups/", "g/getChildren/"])
      .then(([asistentes, ageGroups, children]) => {
        let childrenGroup = [];
        let acuarelauser = document.querySelector("main").dataset.acuarelauser;
        let edades = document.querySelector("main").dataset.edades;
        if (document.querySelector("main").dataset.children) {
          childrenGroup = JSON.parse(
            document.querySelector("main").dataset.children
          );
          childrenGroup = childrenGroup.map((kid) => kid.id);
        }
        // Do something with the fetched data
        asistentes.forEach((asistente) => {
          if (acuarelauser) {
            let { name, id } = asistente;
            document.querySelector("#acuarelauser").innerHTML += `<option ${acuarelauser == id ? `selected` : ``
              } value="${id}">${name}</option>`;
          } else {
            if (!asistente.group) {
              let { name, id } = asistente;
              document.querySelector("#acuarelauser").innerHTML += `<option ${acuarelauser == id ? `selected` : ``
                } value="${id}">${name}</option>`;
            }
          }
        });
        ageGroups.forEach((ageGroup) => {
          let { name } = ageGroup;
          document.querySelector("#edades").innerHTML += `<option ${edades == name ? `selected` : ``
            } value="${name}">${name}</option>`;
        });
        let childrenNoGroup = children.response;
        childrenNoGroup.forEach((kid) => {
          let { name, photo, id, group, coppa_status } = kid;
          let isCoppaLocked = coppa_status && coppa_status !== 'granted';

          let url = null;
          if (photo) {
            url = photo.url;
          }
          if (!group) {
            document.querySelector(".children").innerHTML += `<li ${isCoppaLocked ? 'style="opacity:0.6;"' : ''}>
                          <input type="checkbox" name="${id}" id="${id}" ${childrenGroup.includes(id) ? `checked` : ``
              } onclick="validateCoppaSelection(event, '${coppa_status || 'pending'}')">
                          <label for="${id}" ${isCoppaLocked ? 'style="cursor:pointer;" title="Consentimiento COPPA requerido"' : ''}>
                               ${isCoppaLocked ? '<i class="acuarela acuarela-Bloquear" style="color:red; margin-right:5px; font-size:1.2em;"></i>' : ''}
                               ${photo
                ? `<img src='https://acuarelacore.com/api/${photo.formats.small.url}' alt='${kid.name}'>`
                : `${kid.gender === "Masculino"
                  ? `<img src="img/mal.png" alt="">`
                  : ""
                }${kid.gender === "Femenino"
                  ? `<img src="img/fem.png" alt="">`
                  : ""
                }${kid.gender === "X"
                  ? `<img src="img/Nonbinary.png" alt="">`
                  : ""
                }`
              }
                              <span>${name}</span>
                          </label>
                      </li>`;
          }
        });
        fadeOut(preloader);
      })
      .catch((error) => {
        // Handle errors
        console.error("Error in fetchAllUrls:", error);
      });
  }
};
const getInfoNewAsistente = () => {
  if (
    document.querySelector(".newasistente") ||
    document.querySelector("#estado")
  ) {
    fetchAllUrls(["g/getEstadosCiudades/"])
      .then(([body]) => {
        var estados = Object.keys(body.all_states);
        estados.sort(function (a, b) {
          if (a < b) {
            return -1;
          }
          if (a > b) {
            return 1;
          }
          return 0;
        });
        estados.forEach((estado) => {
          document.querySelector(
            "#estado"
          ).innerHTML += `<option value="${estado}">${estado}</option>`;
        });
        fadeOut(preloader);
      })
      .catch((error) => {
        // Handle errors
        console.error("Error in fetchAllUrls:", error);
      });
  }
};
const fields = document.querySelectorAll("input[required], select[required]");
const percentageSpan = document.querySelector(".percentage");
fields.forEach((field) => {
  field.parentElement.querySelector("label").innerHTML +=
    "<span class='required'>*</span>";
});
function updatePercentage() {
  const totalFields = fields.length;
  let filledFields = 0;

  fields.forEach((field) => {
    if (field.type === "file") {
      if (field.files.length > 0) filledFields++;
    } else if (field.value.trim() !== "") {
      filledFields++;
    }
  });

  const percentage = Math.round((filledFields / totalFields) * 100);
  percentageSpan.textContent = `${percentage}%`;

  if (percentage === 100) {
    document.querySelector(
      ".mainHeader .actions button"
    ).innerHTML = `Publicar`;
  }
  return percentage;
}
const handleEmailChange = (event, index) => {
  const email = event.target.value;
  validateParentEmailExist(email, index).then((parent) => {
    if (parent) {
      showParentLightbox(parent, index);
    } else {
      // Aquí puedes agregar código para manejar si el correo no existe
    }
  });
};

const validateParentEmailExist = async (email, index) => {
  return await fetch(
    `https://acuarelacore.com/api/acuarelausers?mail=${email.toLowerCase()}&rols=5ff790045d6f2e272cfd7394`
  )
    .then((res) => res.json())
    .then((parent) => {
      return parent[0]; // Retorna el primer padre encontrado o undefined si no se encuentra ninguno
    });
};

const fillParentForm = (index, parent) => {
  document.getElementById(`parent_name${index}`).value = parent.name || "";
  document.getElementById(`parent_lastname${index}`).value =
    parent.lastname || "";
  document.getElementById(`parent_phone${index}`).value = parent.phone || "";
};

function showParentLightbox(parent, index) {
  const infoLightbox = document.getElementById("parent-lightbox");
  infoLightbox.style.display = "flex";
  const closeButton = document.getElementById("parent-close-button");
  const closeHandler = () => {
    infoLightbox.style.display = "none";
    closeButton.removeEventListener("click", closeHandler);
  };
  document
    .querySelector("#parent-lightbox #confirm-button")
    .addEventListener("click", () => {
      fillParentForm(index, parent);
      closeHandler();
    });
  closeButton.addEventListener("click", closeHandler);
}

const tabs = document.querySelectorAll(".navtab");
if (tabs.length > 0) {
  const contents = document.querySelectorAll(".tab-content");
  const underline = document.querySelector(".underline");

  function updateUnderline() {
    const activeTab = document.querySelector(".navtab.active");
    underline.style.width = `${activeTab.offsetWidth}px`;
    underline.style.left = `${activeTab.offsetLeft}px`;
  }
  let indexTab = 0;
  if (document.querySelector("#next")) {
    document.querySelector("#next").addEventListener("click", () => {
      tabs.forEach((t) => t.classList.remove("active"));
      indexTab++;
      tabs[indexTab].classList.add("active");
      const target = tabs[indexTab].getAttribute("data-target");
      contents.forEach((content) => {
        if (content.id === target) {
          content.classList.add("active");
        } else {
          content.classList.remove("active");
        }
      });
      updateUnderline();
    });
  }
  tabs.forEach((tab, i) => {
    tab.addEventListener("click", () => {
      const indexTabSelected = tab.getAttribute("data-index");
      indexTab = indexTabSelected;
      tabs.forEach((t) => t.classList.remove("active"));
      tab.classList.add("active");
      const target = tab.getAttribute("data-target");
      contents.forEach((content) => {
        if (content.id === target) {
          content.classList.add("active");
        } else {
          content.classList.remove("active");
        }
      });
      updateUnderline();
    });
  });

  window.addEventListener("resize", updateUnderline);
  updateUnderline();
}

if (document.querySelector(".actividadescontainer")) {
  let currentDate = new Date();

  function displayActivities(date) {
    const dateString = date.toISOString().split("T")[0];
    const activityForDate = activities.filter(
      (activity) => activity.activity.date.split("T")[0] === dateString
    );

    const activitiesListContainer = document.getElementById("activities-list");
    const noActivities = document.getElementById("no-activities");
    const dateDisplay = document.getElementById("date-display");

    dateDisplay.textContent = date.toLocaleDateString("es-ES", {
      month: "long",
      day: "numeric",
    });

    if (activityForDate.length > 0) {
      activitiesListContainer.innerHTML = "";
      activityForDate.forEach((act) => {
        let activity = act.activity;
        const activityElement = document.createElement("div");
        activityElement.className = "activity";
        activityElement.innerHTML = `
        <div class="left">
        <i class="acuarela ${activitiesList.find((actList) => actList.id == activity.classactivity)
            .iconClass
          }"></i>
        <div class="txt">
        <div class="activity-title">${activity.name}</div>
        <div class="activity-desc">
        <p>
        ${activity.infoadicional.comment}
        </p>
          </div>
        </div>
                  </div>
                  <div class="activity-time">${formatFechaAmigable(
            activity.date
          )}</div>
              `;
        activitiesListContainer.appendChild(activityElement);
      });
      activitiesListContainer.style.display = "block";
      noActivities.style.display = "none";
    } else {
      activitiesListContainer.style.display = "none";
      noActivities.style.display = "block";
    }
  }

  document.getElementById("prev-day").addEventListener("click", () => {
    currentDate.setDate(currentDate.getDate() - 1);
    displayActivities(currentDate);
  });

  document.getElementById("next-day").addEventListener("click", () => {
    currentDate.setDate(currentDate.getDate() + 1);
    displayActivities(currentDate);
  });

  document.getElementById("prev-month").addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    displayActivities(currentDate);
  });

  document.getElementById("next-month").addEventListener("click", () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    displayActivities(currentDate);
  });

  displayActivities(currentDate);
}

function showLightbox(title, text, type, id) {
  const lightbox = document.getElementById("lightbox");
  document.getElementById("lightbox-title").innerText = title;
  document.getElementById("lightbox-text").innerText = text;

  lightbox.style.display = "flex";

  const confirmButton = document.getElementById("confirm-button");
  const cancelButton = document.getElementById("cancel-button");

  const confirmHandler = async () => {
    fadeIn(preloader);
    try {
      const response = await fetch(`s/deleteElement/?type=${type}&id=${id}`);
      const deleteResponse = await response.json();
      lightbox.style.display = "none";
      confirmButton.removeEventListener("click", confirmHandler);
      cancelButton.removeEventListener("click", cancelHandler);
      setTimeout(() => {
        window.location.reload();
      }, 200);
    } catch (error) {
      console.error("Error eliminando el contenido:", error);
    }
  };

  const cancelHandler = () => {
    lightbox.style.display = "none";
    confirmButton.removeEventListener("click", confirmHandler);
    cancelButton.removeEventListener("click", cancelHandler);
  };

  confirmButton.addEventListener("click", confirmHandler);
  cancelButton.addEventListener("click", cancelHandler);
}
function showInfoLightbox(title, content) {
  const infoLightbox = document.getElementById("info-lightbox");
  document.getElementById("info-lightbox-title").innerText = title;
  const infoLightboxText = document.getElementById("info-lightbox-text");
  infoLightboxText.innerHTML = ""; // Limpiar contenido previo
  infoLightboxText.appendChild(content); // Añadir nuevo contenido

  infoLightbox.style.display = "flex";

  const closeButton = document.getElementById("info-close-button");

  const closeHandler = () => {
    infoLightbox.style.display = "none";
    closeButton.removeEventListener("click", closeHandler);
  };

  closeButton.addEventListener("click", closeHandler);
}
function openEditAsistente() {
  const infoLightbox = document.getElementById("editasistente-lightbox");
  infoLightbox.style.display = "flex";
  const closeButton = document.getElementById("editasistente-close-button");
  const closeHandler = () => {
    infoLightbox.style.display = "none";
    closeButton.removeEventListener("click", closeHandler);
  };

  closeButton.addEventListener("click", closeHandler);
}

let onceOpen = false;
let activeStepNo = 0;

function showActivityLightbox(showNextStep = false) {
  const lightbox = document.getElementById("lightbox-activities");
  if (showNextStep && !onceOpen) {
    nextStep();
    onceOpen = true;
  } else if (!showNextStep && onceOpen) {
    activeStepNo = 0;
    let activeStep = document.querySelector(".step.active");
    if (activeStep) {
      activeStep.classList.remove("active");
    }
    document
      .querySelectorAll("#createActicity .step")
    [activeStepNo].classList.add("active");
    onceOpen = false;
  }
  lightbox.style.display = "flex";
  const closeButton = document.getElementById("activities-close-button");
  const closeHandler = () => {
    lightbox.style.display = "none";
    document.querySelector("#createActicity").reset();
    activeStepNo = 0;

    let activeStep = document.querySelector(".step.active");
    if (activeStep) {
      activeStep.classList.remove("active");
    }
    document
      .querySelectorAll("#createActicity .step")
    [activeStepNo].classList.add("active");
    closeButton.removeEventListener("click", closeHandler);
  };
  closeButton.addEventListener("click", closeHandler);
}

function updateIconClass(newClass, newName) {
  var icon = document.querySelectorAll(".typeSelectedIcon");
  var name = document.querySelectorAll(".typeSelectedName");
  icon.forEach((icon) => {
    icon.className = ""; // Elimina todas las clases
    icon.classList.add("acuarela", newClass, "typeSelectedIcon"); // Agrega las nuevas clases
  });
  name.forEach((name) => {
    name.innerHTML = newName;
  });
}

let totalSteps = document.querySelectorAll("#createActicity .step").length;
const nextStep = () => {
  activeStepNo++;
  let activeStep = document.querySelector(".step.active");
  if (activeStep) {
    activeStep.classList.remove("active");
  }
  document
    .querySelectorAll("#createActicity .step")
  [activeStepNo].classList.add("active");
};
const prevStep = () => {
  if (activeStepNo > 0) {
    activeStepNo--;
    let activeStep = document.querySelector(".step.active");
    if (activeStep) {
      activeStep.classList.remove("active");
    }
    document
      .querySelectorAll("#createActicity .step")
    [activeStepNo].classList.add("active");
  }
};

const sendActivity = async () => {
  document
    .querySelector(".grupo .steps .btnactions #save")
    .setAttribute("disabled", true);
  fadeIn(preloader);

  const form = document.querySelector("#createActicity"); // Selecciona tu formulario
  const inputs = form.querySelectorAll("[name]"); // Selecciona todos los inputs, selects y textareas
  const formData = {};

  inputs.forEach((input) => {
    if (
      (input.type === "checkbox" || input.type === "radio") &&
      input.checked
    ) {
      formData[input.name] = input.value; // Asigna el valor del input al objeto formData si está marcado
    } else if (input.type !== "checkbox" && input.type !== "radio") {
      formData[input.name] = input.value; // Asigna el valor del input al objeto formData si no es checkbox o radio
    }
  });

  const rateEntries = [];
  for (const key in formData) {
    if (key.startsWith("rate-")) {
      const id = key.split("-")[1];
      const rate = parseFloat(formData[key]);
      rateEntries.push({ id, rate });
    }
  }

  const totalRate = rateEntries.reduce((sum, entry) => sum + entry.rate, 0);
  const averageRate = totalRate / rateEntries.length || 0;
  // Convertir a un objeto Date
  const fecha = new Date();

  const formValues = {
    name: formData.title,
    rate: Math.round(averageRate),
    date: fecha,
    type: [formData.activityType],
    groups: [formData.group],
    children: rateEntries,
    comments: formData.description,
    infoadicional: {
      comment: formData.description,
    },
  };

  const reactionResponse = await fetch("s/createActivity/", {
    method: "POST",
    body: JSON.stringify(formValues),
    headers: { "Content-Type": "application/json" },
  });
  const activityData = await reactionResponse.json();
  fadeOut(preloader);
  window.location.reload();
};
let formValuesInspeccion = {
  fichasNiños: false,
  registroActividades: false,
  registroAsistencia: false,
  fichasAsistentes: false,
  ingresos: false,
  gastos: false,
  payrolls: false,
  visitas: false,
};

document
  .querySelectorAll('.report-content input[type="checkbox"]')
  .forEach((checkbox) => {
    checkbox.addEventListener("change", (event) => {
      const id = event.target.id;
      formValuesInspeccion[id] = event.target.checked;
    });
  });

const generateReport = async () => {
  fadeIn(preloader);
  const initialFilterDate = document.getElementById("start-date").value;
  const finalFilterDate = document.getElementById("end-date").value;
  const daycareId = document.getElementById("daycare").value;

  function convertDate(dateString) {
    // Split the input date by the dash separator
    let dateParts = dateString.split("-");

    // Rearrange the date parts from YYYY-MM-DD to DD-MM-YYYY
    let formattedDate = `${dateParts[2]}-${dateParts[1]}-${dateParts[0]}`;

    return formattedDate;
  }

  let link = `https://acuarela.app/modo-inspeccion/?daycare=${daycareId}&ninos=${formValuesInspeccion.fichasNinos
    }&actividades=${formValuesInspeccion.registroActividades}&asistencia=${formValuesInspeccion.registroAsistencia
    }&asistentes=${formValuesInspeccion.fichasAsistentes}&ingresos=${formValuesInspeccion.ingresos
    }&gastos=${formValuesInspeccion.gastos}&visitas=${formValuesInspeccion.visitas
    }&payrolls=${formValuesInspeccion.payrolls}&from=${convertDate(
      initialFilterDate
    )}&to=${convertDate(finalFilterDate)}&user=${userMainT}`;

  await sendInspectionModeMail(userNameAdmin, emailAdmin, link);
};

const sendInspectionModeMail = async (userName, email, link) => {
  var myHeaders = new Headers();
  var formdata = new FormData();
  formdata.append("email", email);
  formdata.append("admin", userName);
  formdata.append("link", link);
  formdata.append("daycare", foundDaycare.name);

  var requestOptions = {
    method: "POST",
    headers: myHeaders,
    body: formdata,
    redirect: "follow",
  };

  fetch(
    "https://bilingualchildcaretraining.com/s/emailInspeccion/",
    requestOptions
  )
    .then((response) => response.json())
    .then((result) => {
      fadeOut(preloader);
      Toastify({
        text: "Informe enviado a tu correo " + emailAdmin,
        close: true,
        stopOnFocus: true,
        style: {
          background: "linear-gradient(to right, #0cb5c3, #098892)",
        },
        duration: 10000,
      }).showToast();
    })
    .catch((error) => console.log("error", error));
  return true;
};

//Funcionalidad de Mensajería

let roomId;
let user;
let userIdPadre;
let socketPadre;
let userIdAcuarela = acuarelaId;
let padres = [];
let chatsActivos = [];
let padre = [];

// if (currentPath == "/miembros/acuarela-app-web/") {

// console.log("Id Acuarela", acuarelaId);

const socket = io("https://acuarelacore.com", {
  transports: ["websocket", "polling"],
  auth: {
    userId: acuarelaId,
  },
});

socket.emit("register", { userId: acuarelaId });

const asideMensajeria = document.getElementById("mesajeria-menu");
const icono = document.getElementById("icono");
const mensajeButton = document.getElementById("mainButton");
const buscarMensajeria = document.getElementById("buscar-mensajeria");
const buscadorMensajeria = document.getElementById("chats-buscados");
const divChatGrupal = document.getElementById("chat-grupal");
const divPadresChats = document.getElementById("chats-padres");
const divPadresChatsGrupales = document.getElementById(
  "div-lista-chats-grupales"
);
const divPadresInactivos = document.getElementById("padres-inactivos");
const agregarButton = document.getElementById("agregar-mensajeria");
const agregarMensajeria = document.getElementById("chats-agregados");
let chatButton = document.querySelectorAll(".chat-icon");
const chatMensajeria = document.querySelector(".chat-individual");
const btnSendMensaje = document.getElementById("sendBtn");
const chatList = document.getElementById("opciones-mensajeria");
const contendorMessages = document.getElementById("messages");
const grupoMensajeria = document.getElementById("agregar-grupo-mensajeria");
let isChatOpen = false;
let modo = "individual";

mensajeButton.addEventListener("click", function () {
  // Añadir clase para ocultar el ícono actual
  icono.classList.add("icon-hidden");

  setTimeout(() => {
    if (!isChatOpen) {
      // Mostrar asideMensajeria con animación
      asideMensajeria.style.display = "flex"; // Asegurar que sea visible
      setTimeout(() => {
        asideMensajeria.classList.remove("menu-hidden");
        asideMensajeria.classList.add("menu-visible");
      }, 10); // Breve retraso para permitir la transición

      // Cambiar el ícono a "Cancelar"
      icono.classList.remove("acuarela-Habla", "icon-chat");
      icono.classList.add("acuarela-Cancelar", "icon-close");
    } else {
      // Ocultar asideMensajeria con animación
      asideMensajeria.classList.remove("menu-visible");
      asideMensajeria.classList.add("menu-hidden");
      setTimeout(() => {
        asideMensajeria.style.display = "none"; // Ocultar después de la animación
      }, 300); // Duración de la animación en CSS

      // Cambiar el ícono a "Habla"
      icono.classList.remove("acuarela-Cancelar", "icon-close");
      icono.classList.add("acuarela-Habla", "icon-chat");
    }

    // Mostrar el nuevo ícono
    icono.classList.remove("icon-hidden");
    isChatOpen = !isChatOpen; // Alternar estado
  }, 300); // Coincidir con la duración de la animación del ícono
});

async function buscarPadres() {
  try {
    const padresInfo = await fetch(
      `https://acuarelacore.com/api/acuarelausers?rols=5ff790045d6f2e272cfd7394&daycare=${daycareActiveId}`,
      {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      }
    );
    padres = await padresInfo.json();

    const filtrarPadresActivos = padres.filter(
      ((obj) => {
        const seen = new Set();
        return function (item) {
          // Verifica si el correo ya fue encontrado
          if (seen.has(item.email)) {
            return false;
          }
          // Si es nuevo, lo agrega al conjunto y lo mantiene
          seen.add(item.email);
          return true;
        };
      })()
    );

    return filtrarPadresActivos;
  } catch (error) {
    console.log("No se encontraron los padres");
  }
}

async function buscarChatsActivos() {
  try {
    const response = await fetch(
      `https://acuarelacore.com/api/chats?room_contains=${userIdAcuarela}`,
      {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      }
    );
    const chatsActivos = await response.json();

    return chatsActivos;
  } catch (error) {
    console.log("No se pueden listar los chats activos");
  }
}

const sendRegisterEmailChat = async (rol, daycare, email, link, kid) => {
  let baseUrl = `/s/endRegister/?rol=${rol}&daycare=${daycare}&email=${email}&link=${link}&kid=${kid}`;

  await fetch(baseUrl, {
    method: "GET",
    headers: {
      "content-type": "multipart/form-data",
    },
  })
    .then((response) => response.json())
    .then((result) => {
      // alert("El correo de invitación se envió correctamente.");
      Swal.fire({
        title: "¡Exitoso!",
        text: "El correo de invitación se envió correctamente.",
        icon: "success",
        confirmButtonText: "Entendido",
        background: "#f8f9fa",
        color: "#333",
        confirmButtonColor: "#0cb5c3",
      });

      return result;
    })
    .catch((error) => {
      // console.log("Invitation no sended ", error);
      // alert("El correo de invitación no se envió.");
      Swal.fire({
        title: "¡Atención!!",
        text: "El correo de invitación no se envió correctamente.",
        icon: "error",
        confirmButtonText: "Entendido",
        background: "#f8f9fa",
        color: "#333",
        confirmButtonColor: "#0cb5c3",
      });
    });
};

function filtrarPadres(text, padres) {
  if (text === "") {
    mostrarPadres(padres);
  } else {
    const textLower = text.toLowerCase();
    const padresFiltrados = padres.filter(
      (padre) =>
        padre.name.toLowerCase().includes(textLower) ||
        padre.lastname.toLowerCase().includes(textLower)
    );
    mostrarPadres(padresFiltrados);
  }
}

function mostrarPadres(padres) {
  divPadresInactivos.innerHTML = "";
  // btnSendMensaje.removeEventListener('click', enviarMensaje);

  if (padres.length > 0) {
    padres.forEach((padre) => {
      const padreElement = document.createElement("div");
      padreElement.className = "chats-mensajeria";
      padreElement.id = "chats-mensajeria";

      const padrePhoto = document.createElement("img");
      padrePhoto.src =
        "https://bilingualchildcaretraining.com/miembros/acuarela-app-web/img/placeholder.png";
      const padreName = document.createElement("p");
      padreName.id = "chat-padre";

      padreName.textContent = `${padre.name} ${padre.lastname}`;
      padreElement.appendChild(padrePhoto);
      padreElement.appendChild(padreName);
      if (padre.status === false) {
        const btnInvitar = document.createElement("button");
        btnInvitar.id = "btn-invitar";
        btnInvitar.textContent = "Invitar";
        padreElement.appendChild(btnInvitar);

        btnInvitar.addEventListener("click", function () {
          sendRegisterEmailChat(
            "padre",
            foundDaycare.name,
            padre.email,
            `https://acuarelacore.com/auth/register/${padre.id}`,
            padre.children[0].name
          );
          // })
        });
      } else {
        const btnChatear = document.createElement("button");
        btnChatear.id = "btn-invitar";
        btnChatear.textContent = "Chatear";
        padreElement.appendChild(btnChatear);

        btnChatear.addEventListener("click", () => {
          userIdPadre = padre.id;
          socketPadre = padre.socketId;
          cargarChatPadre(padre.id);
          mostrarChat(btnChatear);
          selectedButton = btnChatear;
          mensajeriaPadre();
          // buscarChatsActivos();
        });
      }
      divPadresInactivos.appendChild(padreElement);
    });
  } else {
    const padreElement = document.createElement("div");
    padreElement.className = "chats-mensajeria";
    padreElement.id = "chats-mensaje";
    const padreName = document.createElement("p");
    padreName.id = "chat-padre";
    padreName.textContent = `No hay chats con ese nombre.`;
    padreElement.appendChild(padreName);
    divPadresInactivos.appendChild(padreElement);
  }
}
if (agregarButton) {
  agregarButton.addEventListener("click", divNuevoChat);
}

async function divNuevoChat() {
  chatButton = document.querySelectorAll(".chat-icon");

  if (agregarButton.classList.contains("active")) {
    agregarButton.classList.remove("active");
    buscarMensajeria.classList.remove("inactive");
    grupoMensajeria.classList.remove("inactive");
    buscarMensajeria.addEventListener("click", divBuscarActivos);
    // buscarMensajeria.addEventListener("click", divBuscarActivos);
    chatButton.forEach((boton) => {
      boton.classList.remove("inactive");
      boton.addEventListener("click", activosListener);
    });
  } else {
    agregarButton.classList.add("active");
    buscarMensajeria.classList.add("inactive");
    grupoMensajeria.classList.add("inactive");
    buscarMensajeria.removeEventListener("click", divBuscarActivos);
    chatButton.forEach((boton) => {
      boton.classList.add("inactive");
      boton.removeEventListener("click", activosListener);
    });
  }

  if (agregarMensajeria.style.display === "none") {
    agregarMensajeria.style.display = "block";
    // const btnCerrarAgregar = document.getElementById('closeAgregar');
    document
      .getElementById("closeAgregar")
      .addEventListener("click", divNuevoChat);
    //REVISAR
    const padres = await buscarPadres();
    divPadresInactivos.innerHTML = "";
    const chatsActivos = await buscarChatsActivos();
    //Compara el json de padres con chatsActivos para mostrar solo los que no tengan chats activos
    let padresFiltrados = padres.filter(
      (item1) => !chatsActivos.some((item2) => item2.room.includes(item1.id))
    );

    if (padresFiltrados.length > 0) {
      const btnInvitar = document.getElementById("btn-invitar");
      const inputInvitar = document.getElementById("agregar-chat");

      document
        .getElementById("agregar-chat")
        .addEventListener("keyup", (event) => {
          if (event.code === "Enter") {
            btnInvitar.click();
          }
        });

      btnInvitar.addEventListener("click", function () {
        const textInvitar = inputInvitar.value;
        filtrarPadres(textInvitar, padresFiltrados);
      });
    } else {
      const padreElement = document.createElement("div");
      padreElement.className = "chats-mensajeria";
      padreElement.id = "chats-mensaje";
      const padreName = document.createElement("p");
      padreName.id = "chat-padre";
      padreName.textContent = `No hay chats activos.`;
      padreElement.appendChild(padreName);
      divPadresInactivos.appendChild(padreElement);
    }

    if (padresFiltrados.length > 0) {
      mostrarPadres(padresFiltrados);
    } else {
      const padreElement = document.createElement("div");
      padreElement.className = "chats-mensajeria";
      padreElement.id = "chats-mensaje";
      const padreName = document.createElement("p");
      padreName.id = "chat-padre";
      padreName.textContent = `No hay padres registrados en el daycare.`;
      padreElement.appendChild(padreName);
      divPadresChats.appendChild(padreElement);
    }
  } else {
    agregarMensajeria.style.display = "none";
    document.getElementById("agregar-chat").value = "";
    document
      .getElementById("closeAgregar")
      .removeEventListener("click", divNuevoChat);
    buscarChatsActivos();
  }
  // agregarButton.removeEventListener('click', divNuevoChat);
}

// grupoMensajeria.addEventListener("click", divBuscarActivos)
if (grupoMensajeria) {
  grupoMensajeria.addEventListener("click", () => {
    // modo = "grupal";
    divNuevoChatGrupal();
  });
}

let usuariosSeleccionados = [];
async function divNuevoChatGrupal() {
  usuariosSeleccionados = [];
  chatButton = document.querySelectorAll(".chat-icon");

  if (grupoMensajeria.classList.contains("active")) {
    grupoMensajeria.classList.remove("active");
    buscarMensajeria.classList.remove("inactive");
    agregarButton.classList.remove("inactive");
    // agregarButton.addEventListener("click", divNuevoChat);
    grupoMensajeria.addEventListener("click", divNuevoChatGrupal);
    chatButton.forEach((boton) => {
      boton.classList.remove("inactive");
      boton.addEventListener("click", activosListener);
    });
  } else {
    grupoMensajeria.classList.add("active");
    buscarMensajeria.classList.add("inactive");
    agregarButton.classList.add("inactive");
    // agregarButton.removeEventListener("click", divNuevoChat);
    grupoMensajeria.removeEventListener("click", divNuevoChatGrupal);

    chatButton.forEach((boton) => {
      boton.classList.add("inactive");
      boton.removeEventListener("click", activosListener);
    });
  }

  if (divChatGrupal.style.display === "none") {
    divChatGrupal.style.display = "block";

    document
      .getElementById("closeBuscador-grupal")
      .addEventListener("click", divNuevoChatGrupal);

    if (padres.length === 0) {
      padres = await buscarPadres();
      chatsActivos = await buscarChatsActivos();
    }
    padresActivos = padres.filter((padre) => padre.status === true);

    function filtrarPadres(text, padres) {
      if (text === "") {
        mostrarPadres(padresActivos);
      } else {
        // Convertir el texto de búsqueda y los nombres a minúsculas para hacer la búsqueda case-insensitive
        const textLower = text.toLowerCase();
        const padresActivos = padres.filter(
          (padre) =>
            padre.name.toLowerCase().includes(textLower) ||
            padre.lastname.toLowerCase().includes(textLower) // Puedes incluir también el apellido en el filtro
        );
        mostrarPadres(padresActivos);
      }
    }

    // Map para rastrear los padres seleccionados usando su ID
    const padresSeleccionadosMap = new Map();

    function mostrarPadres(padres) {
      // Limpiar el contenedor antes de renderizar la nueva lista
      divPadresChatsGrupales.innerHTML = "";
      const infoDiv = document.createElement("div");
      infoDiv.className = "instrucciones-grupal";
      const infoText = document.createElement("p");
      infoText.textContent =
        "¡Selecciona al menos 2 padres, haz click en el + y ponle un nombre a tu grupo!";
      infoDiv.appendChild(infoText);
      divPadresChatsGrupales.appendChild(infoDiv);

      if (padres.length > 0) {
        padres.forEach((padre) => {
          const padreElement = document.createElement("div");
          padreElement.className = "chats-mensajeria";

          const padrePhoto = document.createElement("img");
          padrePhoto.src =
            "https://bilingualchildcaretraining.com/miembros/acuarela-app-web/img/placeholder.png";

          const padreName = document.createElement("p");
          padreName.textContent = `${padre.name} ${padre.lastname}`;

          padreElement.appendChild(padrePhoto);
          padreElement.appendChild(padreName);
          divPadresChatsGrupales.appendChild(padreElement);

          // Verificar si este padre ya estaba seleccionado por su ID y agregarle la clase
          if (padresSeleccionadosMap.has(padre.id)) {
            padreElement.classList.add("selected");
          }

          padreElement.addEventListener("click", () => {
            if (padresSeleccionadosMap.has(padre.id)) {
              // Si ya está seleccionado, lo quitamos
              padresSeleccionadosMap.delete(padre.id);
              padreElement.classList.remove("selected");
            } else {
              // Si no está seleccionado, lo agregamos
              padresSeleccionadosMap.set(padre.id, {
                userIdPadre: padre.id,
                nombre: `${padre.name} ${padre.lastname}`,
              });
              padreElement.classList.add("selected");
            }

            // Convertir el Map a un array para mantener compatibilidad con el resto del código
            usuariosSeleccionados = Array.from(padresSeleccionadosMap.values());
          });
        });
      } else {
        const padreElement = document.createElement("div");
        padreElement.className = "chats-mensajeria";
        padreElement.id = "chats-mensaje";
        const padreName = document.createElement("p");
        padreName.textContent = `No hay chats con ese nombre.`;
        padreElement.appendChild(padreName);
        divPadresChatsGrupales.appendChild(padreElement);
      }
    }

    if (padresActivos.length > 0) {
      mostrarPadres(padresActivos);
    } else {
      const padreElement = document.createElement("div");
      padreElement.className = "chats-mensajeria";
      padreElement.id = "chats-mensaje";
      const padreName = document.createElement("p");
      padreName.id = "chat-padre";
      padreName.textContent = `No hay padres registrados en el daycare.`;
      padreElement.appendChild(padreName);
      divPadresChatsGrupales.appendChild(padreElement);
    }

    const inputBuscarChat = document.getElementById("buscador-chat-grupal");
    const bntBuscarChat = document.getElementById("btn-buscador-chat-grupal");
    const bntCrearGrupo = document.getElementById("btn-crear-grupo");

    document
      // .getElementById("buscador-chat")
      .getElementById("buscador-chat-grupal")
      .addEventListener("keyup", (event) => {
        if (event.code === "Enter") {
          bntBuscarChat.click();
        }
      });

    const btnCrearGrupo = document.getElementById("btn-crear-grupo");
    const chatGrupal = document.getElementById("chat-grupal");
    const divListaChats = document.getElementById("div-lista-chats-grupales");

    btnCrearGrupo.addEventListener("click", () => {
      if (document.getElementById("group-name-container")) return; // Evita duplicados

      // Crear el contenedor del input
      const groupNameContainer = document.createElement("div");
      groupNameContainer.id = "group-name-container";
      groupNameContainer.classList.add("group-name-container");

      // Crear el input para el nombre del grupo
      const groupNameInput = document.createElement("input");
      groupNameInput.type = "text";
      groupNameInput.placeholder = "Nombre del grupo";
      groupNameInput.id = "group-name-input";
      groupNameInput.classList.add("group-name-input");

      groupNameInput.addEventListener("keyup", (event) => {
        if (event.code === "Enter") {
          confirmButton.click();
        }
      });

      // Crear botón de confirmación
      const confirmButton = document.createElement("button");
      confirmButton.textContent = "Confirmar";
      confirmButton.classList.add("confirm-group-name");

      // Agregar elementos al contenedor
      groupNameContainer.appendChild(groupNameInput);
      groupNameContainer.appendChild(confirmButton);

      // Insertar dentro del div chat-grupal
      divListaChats.appendChild(groupNameContainer);
      divListaChats.scrollTop = divListaChats.scrollHeight;

      // Evento de confirmación
      confirmButton.addEventListener("click", () => {
        const groupName = groupNameInput.value.trim();
        if (
          usuariosSeleccionados.length === 0 ||
          usuariosSeleccionados.length < 2
        ) {
          // alert("Por favor, elije al menos un integrante");
          Swal.fire({
            title: "¡Atención!",
            text: "Por favor, elije al menos dos integrantes.",
            icon: "warning", // "success", "error", "info", "question"
            confirmButtonText: "Entendido",
            background: "#f8f9fa",
            color: "#333",
            confirmButtonColor: "#0cb5c3",
          });
          return;
        }
        if (!groupName) {
          // alert("Por favor, ingresa un nombre para el grupo.");
          Swal.fire({
            title: "¡Atención!",
            text: "Por favor, ingresa un nombre para el grupo.",
            icon: "warning",
            confirmButtonText: "Entendido",
            background: "#f8f9fa",
            color: "#333",
            confirmButtonColor: "#0cb5c3",
          });
          return;
        }

        // Aquí puedes llamar a la función que crea el chat grupal

        // Puedes llamar a tu función aquí con el nombre del grupo
        // crearChatGrupal(usuariosSeleccionados, groupName);

        // roomId = `group_${[acuarelaId, ...usuariosSeleccionados].sort().join("_")}`;
        const participantIds = usuariosSeleccionados.map(
          (user) => user.userIdPadre
        );
        roomId = getRoomName(acuarelaId, participantIds);
        participantIds.push(acuarelaId);

        // const roomId = `group_${[acuarelaId, ...participantIds]
        //   .sort()
        //   .join("_")}`;
        // console.log(roomId);

        // roomId = getRoomName(acuarelaId, participantIds);

        socket.emit("createChat", {
          roomId: roomId, // ID único de la sala
          senderId: acuarelaId, // ID del usuario que inicia el chat
          receiverId: "", // ID del receptor (si es chat privado)
          participants: participantIds, // Lista de participantes
          group_name: groupName, // Nombre del grupo (si es un chat grupal)
        });

        // cargarChatGrupal(roomId);
        cargarChatPadre(roomId);
        mostrarChat(confirmButton);
        mensajeriaPadre();

        // Eliminar el input después de confirmar
        divListaChats.removeChild(groupNameContainer);
        document
          .querySelectorAll(".chats-mensajeria.selected")
          .forEach((chat) => {
            chat.classList.remove("selected");
          });
        usuariosSeleccionados = [];
      });
    });

    inputBuscarChat.addEventListener("keyup", (event) => {
      if (event.code === "Enter") {
        bntBuscarChat.click();
      }
    });

    bntBuscarChat.addEventListener("click", () => {
      const textBuscarChat = inputBuscarChat.value;
      divPadresChatsGrupales.innerHTML = "";
      filtrarPadres(textBuscarChat, padresActivos);
    });
  } else {
    divChatGrupal.style.display = "none";
    document.getElementById("buscador-chat").value = "";
    document
      .getElementById("closeBuscador-grupal")
      .removeEventListener("click", divNuevoChatGrupal);
    buscarChatsActivos();
  }
}

socket.on(
  "createChat",
  async ({ roomId, senderId, receiverId, participants, group_name }) => {
    // Buscar el chat correspondiente a la sala
    let chat = await strapi.services.chats.findOne({ room: roomId });

    // Si no existe, crearlo
    if (!chat) {
      chat = await strapi.services.chats.create({
        sender: senderId,
        receiver: receiverId,
        isRead: false,
        room: roomId,
        messages: {},
        participants,
        group_name,
      });
    }
  }
);
if (document.getElementById("closeBuscador")) {
  document.getElementById("closeBuscador").addEventListener("click", () => {
    buscarMensajeria.click();
  });
}
if (buscarMensajeria) {
  buscarMensajeria.addEventListener("click", divBuscarActivos);
}

async function divBuscarActivos() {
  chatButton = document.querySelectorAll(".chat-icon");

  if (buscarMensajeria.classList.contains("active")) {
    buscarMensajeria.classList.remove("active");
    agregarButton.classList.remove("inactive");
    grupoMensajeria.classList.remove("inactive");
    agregarButton.addEventListener("click", divNuevoChat);
    chatButton.forEach((boton) => {
      boton.classList.remove("inactive");
      boton.addEventListener("click", activosListener);
    });
  } else {
    buscarMensajeria.classList.add("active");
    agregarButton.classList.add("inactive");
    grupoMensajeria.classList.add("inactive");
    agregarButton.removeEventListener("click", divNuevoChat);
    chatButton.forEach((boton) => {
      boton.classList.add("inactive");
      boton.removeEventListener("click", activosListener);
    });
  }

  if (buscadorMensajeria.style.display === "none") {
    buscadorMensajeria.style.display = "block";

    //Revisar
    // if (padres.length === 0) {
    padres = await buscarPadres();
    chatsActivos = await buscarChatsActivos();
    // }

    padresActivos = padres.filter((padre) => padre.status === true);

    //Se compara el json de padres con el de chats activos para mostrar solo los padres que tengan chats activos

    let padresFiltrados = padresActivos.filter((item1) =>
      chatsActivos.some((item2) => item2.room.includes(item1.id))
    );

    const chats = generarListaChats(chatsActivos, padresFiltrados);
    mostrarPadres(chats);
    function filtrarPadres(text, padres) {
      if (text === "") {
        mostrarPadres(padres);
      } else {
        // Convertir el texto de búsqueda y los nombres a minúsculas para hacer la búsqueda case-insensitive
        const textLower = text.toLowerCase();
        const padresFiltrados = padres.filter(
          (padre) =>
            padre.name &&
            typeof padre.name === "string" &&
            padre.name.toLowerCase().includes(textLower)
        );

        mostrarPadres(padresFiltrados);
      }
    }

    function mostrarPadres(padres) {
      divPadresChats.innerHTML = "";

      if (padres.length > 0) {
        padres.forEach((padre) => {
          const padreElement = document.createElement("div");
          padreElement.className = "chats-mensajeria";
          const padrePhoto = document.createElement("img");
          padrePhoto.src =
            "https://bilingualchildcaretraining.com/miembros/acuarela-app-web/img/placeholder.png";
          // padrePhoto.src = "./img/caras/veryHappy.svg";
          const padreName = document.createElement("p");
          padreName.id = "chat-padre";
          padreName.textContent = `${padre.name}`;
          padreElement.appendChild(padrePhoto);
          padreElement.appendChild(padreName);
          divPadresChats.appendChild(padreElement);

          padreElement.addEventListener("click", () => {
            userIdPadre = padre.id;
            socketPadre = padre.socketId;
            cargarChatPadre(padre.id);
            mostrarChat(padreElement);
            selectedButton = padreElement;
            mensajeriaPadre();
            agregarIcon(padre);
            padreInfo = padre;
          });
        });
      } else {
        const padreElement = document.createElement("div");
        padreElement.className = "chats-mensajeria";
        padreElement.id = "chats-mensaje";
        const padreName = document.createElement("p");
        padreName.id = "chat-padre";
        padreName.textContent = `No hay chats con ese nombre.`;
        padreElement.appendChild(padreName);
        divPadresChats.appendChild(padreElement);
      }
    }
    if (padresFiltrados.length > 0) {
      mostrarPadres(chats);
    } else {
      const padreElement = document.createElement("div");
      padreElement.className = "chats-mensajeria";
      padreElement.id = "chats-mensaje";
      const padreName = document.createElement("p");
      padreName.id = "chat-padre";
      padreName.textContent = `No hay padres registrados en el daycare.`;
      padreElement.appendChild(padreName);
      divPadresChats.appendChild(padreElement);
    }

    const inputBuscarChat = document.getElementById("buscador-chat");

    const bntBuscarChat = document.getElementById("btn-buscador-chat");

    document
      .getElementById("buscador-chat")
      .addEventListener("keyup", (event) => {
        if (event.code === "Enter") {
          bntBuscarChat.click();
        }
      });
    bntBuscarChat.addEventListener("click", () => {
      const textBuscarChat = inputBuscarChat.value;
      divPadresChats.innerHTML = "";
      filtrarPadres(textBuscarChat, chats);
    });
  } else {
    buscadorMensajeria.style.display = "none";

    document.getElementById("buscador-chat").value = "";
  }
}

function generarListaChats(chatsActivos, padres) {
  return chatsActivos
    .map((chat) => {
      if (chat.room.includes("group_")) {
        // Chat grupal: tomar group_name y el room como ID
        return {
          id: chat.room,
          name: chat.group_name,
        };
      } else {
        // Chat individual: buscar el padre correspondiente
        const padre = padres.find((p) => chat.room.includes(p._id));

        // let padre = padres.filter((item1) =>
        //   chatsActivos.some((item2) => item2.room.includes(item1.id))
        // );
        return padre
          ? {
            id: padre.id,
            name: `${padre.name} ${padre.lastname}`,
          }
          : null;
      }
    })
    .filter((chat) => chat !== null); // Filtrar los valores nulos por seguridad
}

function mostrarChat(boton) {
  selectedButton = boton;
  contendorMessages.innerHTML = "";

  if (boton.classList.contains("active")) {
    // Si el botón ya está activo, lo inactivamos
    boton.classList.remove("active");
    boton.classList.add("inactive");
    buscarMensajeria.classList.remove("inactive");
    agregarButton.classList.remove("inactive");
    grupoMensajeria.classList.remove("inactive");
    // Restauramos la opacidad de todos los botones
    chatButton.forEach((btn) => btn.classList.remove("inactive"));
  } else {
    // Si el botón no está activo, inactivamos todos los botones y activamos el clicado
    chatButton.forEach((btn) => {
      btn.classList.remove("active");
      btn.classList.add("inactive");
      buscarMensajeria.classList.add("inactive");
      agregarButton.classList.add("inactive");
      grupoMensajeria.classList.add("inactive");
      // opcionesMensajeria.classList.add("inactive");
    });
    // Activamos solo el botón clicado
    boton.classList.remove("inactive");
    boton.classList.add("active");
  }
  if (chatMensajeria.style.display === "none") {
    chatMensajeria.style.display = "block";
    // const contendorMessages = document.getElementById("messages");
    contendorMessages.textContent = "";
    // document.getElementById('closeChat').addEventListener('click',);
    // cerrarChat.addEventListener('click', manejarCierreChat);
  } else {
    chatMensajeria.style.display = "none";
    // const contendorMessages = document.getElementById("messages");
    // boton.removeEventListener('click');
    const messageInput = document.getElementById("messageInput");
    messageInput.value = "";
    roomId = null;
    contendorMessages.innerHTML = "";
    // cerrarChat.removeEventListener('click', manejarCierreChat);
    // contendorMessages.textContent = '';
  }
}
let selectedButton = null;
const cerrarChat = document.getElementById("closeChat");
if (cerrarChat) {
  cerrarChat.addEventListener("click", () => {
    const messageInput = document.getElementById("messageInput");
    messageInput.value = "";
    mostrarChat(selectedButton);
    // activosListener();
  });
}

let chatMessages = [];
let mesesMostrados = [];
let isLoadingOlderMessages = false;

async function cargarChatPadre(userIdPadre) {
  contendorMessages.removeEventListener("scroll", cargarMensajeScroll);
  contendorMessages.innerHTML = "";

  if (userIdPadre.includes("group_")) {
    try {
      const grupoInfo = await fetch(
        `https://acuarelacore.com/api/chats?room=${userIdPadre}`,
        {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
          },
        }
      );
      const grupo = await grupoInfo.json();
      const usuarioName = document.getElementById("userChat");
      const usuarioImg = document.getElementById("imgUser");
      usuarioImg.src = `https://bilingualchildcaretraining.com/miembros/acuarela-app-web/img/placeholder.png`;
      usuarioName.textContent = `${grupo[0].group_name}`;

      user = userNameAdmin;
      roomId = userIdPadre;

      socket.emit("joinRoom", { roomId, user });

      const currentMonth = new Date().toISOString().slice(0, 7);

      chatMessages = grupo;

      isLoadingOlderMessages = false;
      cargarMessages(currentMonth);
      contendorMessages.addEventListener("scroll", cargarMensajeScroll);
    } catch (error) {
      console.log(error);
    }
  } else {
    try {
      const usuarioInfo = await fetch(
        `https://acuarelacore.com/api/acuarelausers/${userIdPadre}`,
        {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
          },
        }
      );
      const usuario = await usuarioInfo.json();
      const usuarioName = document.getElementById("userChat");
      const usuarioImg = document.getElementById("imgUser");
      usuarioImg.src = `https://bilingualchildcaretraining.com/miembros/acuarela-app-web/img/placeholder.png`;
      usuarioName.textContent = `${usuario.name} ${usuario.lastname}`;
    } catch (error) {
      console.error(error);
    }

    roomId = getRoomName(acuarelaId, userIdPadre);
    user = userNameAdmin;

    if (roomId && user) {
      socket.emit("joinRoom", { roomId, user });
    }

    try {
      const messages = await fetch(
        `https://acuarelacore.com/api/chats?room=${roomId}`,
        {
          method: "GET",
          headers: {
            "Content-Type": "application/json",
          },
        }
      );

      chatMessages = await messages.json();

      const currentMonth = new Date().toISOString().slice(0, 7);

      mesesMostrados = [currentMonth];
      isLoadingOlderMessages = false;
      cargarMessages(currentMonth);
      contendorMessages.addEventListener("scroll", cargarMensajeScroll);
    } catch (error) {
      console.error("Error fetching chat messages:", error);
      const errorElement = document.createElement("div");
      errorElement.className = "chat-mensajes";
      errorElement.id = "messages";
      errorElement.textContent = "Error al cargar los mensajes.";
      document.getElementById("messages").appendChild(errorElement);
    }
  }
}

let participants = [];

let MesMostrado = "";
function cargarMessages(mes, mostrarPreloader = true) {
  const messagesContainer = document.getElementById("messages");
  let preloader;

  // Mostrar el preloader solo si mostrarPreloader es true
  if (mostrarPreloader) {
    preloader = document.createElement("div");
    preloader.className = "preloader";
    preloader.innerHTML = '<img src="img/preloader.gif" alt="preloader">';
    messagesContainer.appendChild(preloader);
  }

  setTimeout(
    () => {
      if (chatMessages && chatMessages.length > 0 && chatMessages[0].messages) {
        const messagesMonths = chatMessages[0].messages;
        participants = chatMessages[0].participants;

        const esGrupo = chatMessages[0].room.includes("group_");

        let mesesDisponibles = Object.keys(messagesMonths).sort().reverse();

        // Si el mes solicitado no tiene mensajes, buscar el siguiente mes con datos
        while (mes && !messagesMonths[mes] && mesesDisponibles.length > 0) {
          let index = mesesDisponibles.indexOf(mes);
          // if (index === -1 || index === mesesDisponibles.length - 1) break;

          // if (index === -1 || !mesesDisponibles[index + 1]) {
          //   break; // Detenemos el flujo si no hay un siguiente mes válido
          // }
          mes = mesesDisponibles[index + 1]; // Buscar el siguiente mes disponible
          MesMostrado = mes;
          mesesMostrados = [mes];
        }

        if (!mes || !messagesMonths[mes]) {
          // console.log("No hay mensajes en ningún mes.");
          if (preloader) preloader.remove();
          mostrarMensajeNoHayMensajes();
          return;
        }

        mesesMostrados = [mes];

        // console.log(`Cargando mensajes desde el mes: ${mes}`);

        let mensajesCargados = messagesMonths[mes].slice().reverse(); // Cargar solo del mes indicado

        if (mensajesCargados.length === 0) {
          console.log("No hay mensajes disponibles en este mes.");
          if (preloader) preloader.remove();
          mostrarMensajeNoHayMensajes();
          return;
        }

        // Guardar la posición actual del scroll
        const currentScrollPosition =
          messagesContainer.scrollHeight - messagesContainer.scrollTop;

        mensajesCargados.forEach((msg) => {
          const messageElement = document.createElement("div");
          const mensajeElement = document.createElement("p");
          const nameElement = document.createElement("p");
          const horaElement = document.createElement("p");
          horaElement.className = "chat-hora";
          nameElement.className = "chat-name";

          // Obtener la hora del mensaje
          const horaMensaje = new Date(msg.timestamp);
          const options = { hour: "2-digit", minute: "2-digit", hour12: true };
          horaElement.textContent = horaMensaje.toLocaleTimeString([], options);

          // Si es grupo, obtener el nombre del remitente
          if (esGrupo && msg.sender !== acuarelaId) {
            const participante = participants.find((p) => p.id === msg.sender);
            if (participante) {
              nameElement.textContent = `${participante.name} ${participante.lastname}`;
              messageElement.appendChild(nameElement);
            }
          }

          mensajeElement.textContent = msg.content;
          messageElement.appendChild(mensajeElement);
          messageElement.appendChild(horaElement);

          messageElement.className =
            msg.sender === acuarelaId ? "mensaje-enviado" : "mensaje-recibido";

          messagesContainer.insertBefore(
            messageElement,
            messagesContainer.firstChild
          );
        });

        // Ajustar la posición del scroll para evitar saltos
        messagesContainer.scrollTop =
          messagesContainer.scrollHeight - currentScrollPosition;
        isLoadingOlderMessages = false;
        verificarScrollInicial();
      } else {
        mostrarMensajeNoHayMensajes();
      }

      if (preloader) preloader.remove();
    },
    mostrarPreloader ? 1000 : 0
  );
}

// Función para mostrar el mensaje "No hay mensajes previos"
function mostrarMensajeNoHayMensajes() {
  const noMessagesElement = document.createElement("div");
  noMessagesElement.className = "no-more-messages";
  noMessagesElement.id = "noMessages";
  noMessagesElement.textContent = "No hay mensajes previos.";

  const divChat = document.createElement("div");
  divChat.id = "messageChat";
  const messageChat = document.createElement("p");
  messageChat.textContent = "¡Envía un mensaje para empezar la conversación!  ";
  divChat.appendChild(messageChat);
  const icono = document.createElement("i");
  icono.classList.add("acuarela", "acuarela-Enviar");
  messageChat.appendChild(icono);

  document.getElementById("messages").appendChild(noMessagesElement);
  document.getElementById("messages").appendChild(divChat);
}

function cargarMensajeScroll() {
  if (contendorMessages.scrollTop === 0 && !isLoadingOlderMessages) {
    isLoadingOlderMessages = true;
    // Si llegamos al tope superior, cargar los mensajes del mes anterior
    cargarMesAnterior();
  }
}

function verificarScrollInicial() {
  if (contendorMessages.scrollHeight <= contendorMessages.clientHeight) {
    // Si el contenedor no tiene suficiente contenido para el scroll, cargar más mensajes
    cargarMesAnterior();
  }
}

function restarMes(mes) {
  const availableMonths = Object.keys(chatMessages[0].messages)
    .sort()
    .reverse(); // Ordenar de más reciente a más antiguo
  const index = availableMonths.indexOf(mes);

  if (index === -1 || index === availableMonths.length - 1) {
    return null; // No hay meses anteriores disponibles
  }

  return availableMonths[index + 1]; // Retorna el mes anterior disponible
}

function cargarMesAnterior() {
  const ultimoMesMostrado = mesesMostrados[mesesMostrados.length - 1];
  const mesAnterior = restarMes(ultimoMesMostrado);
  // Verificar si tenemos mensajes para ese mes anterior
  if (chatMessages[0].messages[mesAnterior]) {
    const noMessagesElement = document.createElement("div");
    noMessagesElement.className = "no-more-messages";
    noMessagesElement.textContent = ultimoMesMostrado;

    // Insertar el mensaje en la parte superior del contenedor de mensajes
    const contenedorMessages = document.getElementById("messages");
    contenedorMessages.insertBefore(
      noMessagesElement,
      contenedorMessages.firstChild
    );

    cargarMessages(mesAnterior, false); // Mostrar los chats del mes anterior
    mesesMostrados.push(mesAnterior); // Agregar el nuevo mes a la lista de meses mostrados
  } else {
    const fechaElement = document.createElement("div");
    fechaElement.className = "no-more-messages";
    fechaElement.textContent = ultimoMesMostrado;
    const contenedorMessages = document.getElementById("messages");
    contenedorMessages.insertBefore(
      fechaElement,
      contenedorMessages.firstChild
    );
    // Solo mostrar el mensaje si no se ha mostrado antes

    // if (!noMoreMessagesShown) {
    const noMessagesElement = document.createElement("div");
    noMessagesElement.className = "no-more-messages";
    noMessagesElement.textContent = "No hay más mensajes para mostrar.";
    contenedorMessages.insertBefore(
      noMessagesElement,
      contenedorMessages.firstChild
    );

    isLoadingOlderMessages = true;
  }
}

function getRoomName(user, participants) {
  if (!Array.isArray(participants)) {
    participants = [participants]; // Convertir en array si es un solo usuario
  }

  let userIds = [...participants, user].sort(); // Ordenar IDs (incluyendo el admin)

  return userIds.length > 2
    ? `group_${userIds.join("_")}` // Chat grupal con prefijo "group_"
    : userIds.join("-"); // Chat individual sin prefijo
}

// let clickListenerAttached = false;

function mensajeriaPadre() {
  document.getElementById("messageInput").addEventListener("keyup", (event) => {
    if (event.code === "Enter") {
      btnSendMensaje.click();
    }
  });

  // Agregar el event listener solo una vez
  // if (!clickListenerAttached) {
  btnSendMensaje.addEventListener("click", enviarMensaje);
  // clickListenerAttached = true;
  // }
  // console.log(clickListenerAttached);
}

function enviarMensaje() {
  const messageInput = document.getElementById("messageInput");
  const message = messageInput.value;

  const messageChatElement = document.getElementById("messageChat");
  if (messageChatElement) {
    messageChatElement.remove();
  }

  if (message) {
    if (messageInput.value && roomId) {
      const message = {
        text: messageInput.value,
        user: user,
        timestamp: Date(),
        senderId: acuarelaId,
        receiverId: userIdPadre,
        roomId,
        socketid: socketPadre,
      };
      socket.emit("sendMessage", message);

      messageInput.value = ""; // Limpiar el campo de entrada
      const messageElement = document.createElement("div");
      messageElement.className = "mensaje-enviado";
      const mensajeElement = document.createElement("p");
      mensajeElement.textContent = message.text;
      const horaElement = document.createElement("p");
      horaElement.className = "chat-hora";
      const horaMenssage = new Date(message.timestamp);
      const options = { hour: "2-digit", minute: "2-digit", hour12: true };
      const formattedTime = horaMenssage.toLocaleTimeString([], options);
      horaElement.textContent = formattedTime;
      messageElement.appendChild(mensajeElement);
      messageElement.appendChild(horaElement);
      const lastMessageElement = document
        .getElementById("messages")
        .appendChild(messageElement);
      lastMessageElement.scrollIntoView({ behavior: "smooth" });
    }
  }
}

function showNotification(notificationMessage, notificationtitle) {
  if (!("Notification" in window)) {
    console.error("Este navegador no soporta notificaciones.");
    return;
  }

  if (Notification.permission === "granted") {
    new Notification(notificationtitle, {
      body: notificationMessage,
      icon: "https://bilingualchildcaretraining.com/img/logo_claro.svg",
    });
  } else if (Notification.permission !== "denied") {
    Notification.requestPermission().then((permission) => {
      if (permission === "granted") {
        new Notification(notificationtitle, {
          body: notificationMessage,
          icon: "https://bilingualchildcaretraining.com/img/logo_claro.svg",
        });
      }
    });
  }
}

// showNotification("Hola esta es una prueba", "Prueba");

socket.off("receiveMessage");

socket.on("receiveMessage", (message) => {
  const messageChatElement = document.getElementById("messageChat");
  if (messageChatElement) {
    messageChatElement.remove();
  }

  if (message.sender !== userIdAcuarela) {
    const messageElement = document.createElement("div");
    messageElement.className = "mensaje-recibido";

    //si es grupo incluye en nombre del sender
    const esGrupo = message.roomId.includes("group_");

    if (esGrupo && message.sender !== acuarelaId) {
      const nameElement = document.createElement("p");
      nameElement.className = "chat-name";

      const participante = participants.find((p) => p.id === message.sender);
      if (participante) {
        nameElement.textContent = `${participante.name} ${participante.lastname}`;
        messageElement.appendChild(nameElement); // Agregar el nombre antes del mensaje
      }
    }
    const mensajeElement = document.createElement("p");
    mensajeElement.textContent = message.content;
    const horaElement = document.createElement("p");
    horaElement.className = "chat-hora";
    const horaMenssage = new Date(message.timestamp);
    const options = { hour: "2-digit", minute: "2-digit", hour12: true };
    const formattedTime = horaMenssage.toLocaleTimeString([], options);
    horaElement.textContent = formattedTime;
    messageElement.appendChild(mensajeElement);
    messageElement.appendChild(horaElement);
    const lastMessageElement = document
      .getElementById("messages")
      .appendChild(messageElement);
    lastMessageElement.scrollIntoView({ behavior: "smooth" });
  }
});

socket.on("newMessageNotification", (msg) => {
  const {
    message: { sender, content },
  } = msg;
  showNotification(content, sender);
});

function agregarIcon(padre) {
  let icons = JSON.parse(sessionStorage.getItem("icons")) || [];
  if (!icons.includes(padre.id)) {
    icons.unshift(padre.id);
  }
  if (icons.length > 3) {
    icons.pop();
  }
  sessionStorage.setItem("icons", JSON.stringify(icons));
  // cargarIcons(padre);
  cargarIcons();
}
cargarIcons();

async function activosListener() {
  if (this.classList.contains("active")) {
    cerrarChat.click();
    // agregarButton.addEventListener('click', divNuevoChat);
    // buscarMensajeria.addEventListener('click', divBuscarActivos);
    return;
  }
  // agregarButton.removeEventListener('click', divNuevoChat);
  // buscarMensajeria.removeEventListener('click', divBuscarActivos);
  let usuario;
  try {
    const usuarioInfo = await fetch(
      `https://acuarelacore.com/api/acuarelausers/${this.dataset.iconId}`,
      {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      }
    );
    usuario = await usuarioInfo.json();
  } catch (error) {
    console.error(error);
  }

  userIdPadre = usuario.id;
  socketPadre = usuario.socketId;
  cargarChatPadre(this.dataset.iconId);
  mostrarChat(this);
  mensajeriaPadre();
}

async function cargarIcons() {
  const ulOpciones = document.getElementById("opciones-mensajeria");
  const itemsToRemove = ulOpciones.querySelectorAll("li.chat-icon");
  // Remover íconos anteriores
  itemsToRemove.forEach((item) => {
    ulOpciones.removeChild(item);
  });
  const icons = JSON.parse(sessionStorage.getItem("icons")) || [];

  // Crear íconos
  for (const icon of icons) {
    const iconElement = document.createElement("li");
    iconElement.className = "chat-icon";
    // Guardar el id del ícono en un atributo data para accederlo dentro de la función
    iconElement.dataset.iconId = icon;
    const imgIcon = document.createElement("img");
    imgIcon.src =
      "https://bilingualchildcaretraining.com/miembros/acuarela-app-web/img/placeholder.png";
    iconElement.appendChild(imgIcon);
    ulOpciones.appendChild(iconElement);
    // Agregar listener
    iconElement.addEventListener("click", activosListener);
  }
  // Obtener todos los botones para poder eliminar el listener después
  chatButton = document.querySelectorAll(".chat-icon");
}

// }

// });

//Función para cambiar valores en múltiples contenedores, para mostrarlos en el resumen 
function changeValuesForMultipleContainers(event, selectors) {
  const value = event.target.value;
  for (const selector in selectors) {
    const text = selectors[selector].replace("{value}", value);
    document.querySelectorAll(selector).forEach(el => {
      el.innerHTML = text;
    });
  }
}

document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('input[type="date"]').forEach(input => {
    const selectorsData = input.dataset.selectors ? JSON.parse(input.dataset.selectors) : null;

    const updateValue = (value) => {
      if (!selectorsData) return;
      for (const [selector, valueTemplate] of Object.entries(selectorsData)) {
        document.querySelectorAll(selector).forEach(container => {
          container.innerText = valueTemplate.replace("{value}", value);
        });
      }
    };

    // Evento para la mayoría de navegadores
    input.addEventListener('change', (e) => updateValue(e.target.value));

    // Safari: usar 'input' y forzar cierre
    input.addEventListener('input', (e) => {
      updateValue(e.target.value);
      setTimeout(() => e.target.blur(), 0); // cierra el datepicker
    });
  });
});

const getAllCategories = async () => {
  const resp = await fetchToken("categories");
  const body = await resp.json();
  console.log(body);
};

// tutos de video

function openVideoModal(videoPath) {
  // Crear o seleccionar un modal para mostrar el video
  const modal = document.createElement("div");
  modal.classList.add("video-modal");

  // Añadir el contenido del modal con un elemento <video> para mostrar el video local
  modal.innerHTML = `
    <div class="video-modal-content" onclick="event.stopPropagation()">
      <span class="close-modal" onclick="closeVideoModal()">&times;</span>
      <video id="video-player" width="560" height="315" controls autoplay>
        <source src="${videoPath}" type="video/mp4">
        Tu navegador no soporta el elemento de video.
      </video>
    </div>
  `;

  // Añadir el modal al cuerpo del documento
  document.body.appendChild(modal);

  const videoElement = document.getElementById("video-player");
  videoElement.volume = 0.5; // Volumen al 50%

  // Cerrar el modal al hacer clic fuera del contenedor de contenido
  modal.addEventListener("click", closeVideoModal);
}

function closeVideoModal() {
  const modal = document.querySelector(".video-modal");
  if (modal) {
    modal.remove(); // Eliminar el modal del DOM
  }
}

function handleAddCategories(event, type) {
  document.querySelector("#addCategoriesGastos button").innerHTML =
    "Guardando...";
  event.preventDefault(); // Prevent the form from reloading the page

  const input = document.getElementById("categories-input").value.trim();

  if (!input) {
    alert("Por favor, ingrese al menos una categoría.");
    return;
  }

  // Split categories by comma and trim extra spaces
  const categories = input
    .split(",")
    .map((category) => category.trim())
    .filter((category) => category);

  if (categories.length === 0) {
    alert("No se detectaron categorías válidas.");
    return;
  }

  // Function to send each category to the server
  const sendCategory = async (category) => {
    const formdata = new FormData();
    formdata.append("name", category); // Assuming `category` is the name
    formdata.append("type", type); // Replace "gasto" with dynamic type if needed

    try {
      const response = await fetch("s/addCategories/", {
        method: "POST",
        body: formdata,
      });

      if (!response.ok) {
        throw new Error(`Error al enviar la categoría: ${category}`);
      }

      const result = await response.json();
      document.querySelector("#addCategoriesGastos button").innerHTML =
        "Agregar";
      console.log(`Categoría "${category}" procesada con éxito:`, result);
    } catch (error) {
      console.error(`Error al procesar la categoría "${category}":`, error);
      throw error; // To ensure Promise.all catches this error
    }
  };

  // Process each category asynchronously
  const promises = categories.map(sendCategory);

  // Wait for all promises to resolve
  Promise.all(promises)
    .then(() => {
      alert("Todas las categorías han sido procesadas.");
      document.getElementById("categories-input").value = ""; // Clear the input
      fadeOut(document.querySelector("#lightbox-categories-gastos"));
    })
    .catch((error) => {
      alert(
        `Ocurrió un error al procesar algunas categorías: ${error.message}`
      );
    });
}

function createInvoice() {
  document.querySelector("#addInvoiceForm .content").style.display = "none";
  document.querySelector("#addInvoiceForm .advert").style.display = "block";
  let name = document.querySelector("#addInvoiceForm #payer_name").value;
  let amount = document.querySelector("#addInvoiceForm #amount").value;
  document.querySelector(".advert span.name").innerHTML = name;
  document.querySelector(".advert span.amount").innerHTML = amount;
}
const sendPendingNotification = (linkDePago) => {
  let amount = document.querySelector("#addInvoiceForm #amount").value;
  let payEm = document.querySelector("#addInvoiceForm #payer_email").value;
  const myHeaders = new Headers();

  const formdata = new FormData();
  formdata.append("email", `${payEm}`);
  formdata.append("link", `${linkDePago}`);
  formdata.append("amount", `${amount}`);

  const requestOptions = {
    method: "POST",
    headers: myHeaders,
    body: formdata,
    redirect: "follow",
  };

  fetch(
    "https://bilingualchildcaretraining.com/s/pendingMovementsEmail/",
    requestOptions
  )
    .then((response) => response.json())
    .then((result) => {
      return true;
    })
    .catch((error) => {
      return false;
    });
};
async function handleAddMovement(event) {
  document.querySelector("#addInvoiceForm button").innerHTML = "Guardando...";
  event.preventDefault(); // Prevent the form from reloading the page

  // Function to send each category to the server
  const formdata = new FormData();
  formdata.append("name", document.querySelector("#name").value); // Assuming `category` is the name
  formdata.append("payer_name", document.querySelector("#payer_name").value); // Replace "gasto" with dynamic type if needed
  formdata.append("date", document.querySelector("#date").value); // Replace "gasto" with dynamic type if needed
  formdata.append("amount", document.querySelector("#amount").value); // Replace "gasto" with dynamic type if needed
  try {
    const response = await fetch("s/createPayLink/", {
      method: "POST",
      body: formdata,
    });

    if (!response.ok) {
      throw new Error(`Error al enviar la categoría: ${category}`);
    }

    const result = await response.json();
    document.querySelector("#addInvoiceForm button").innerHTML = "Agregar";
    // Process each category asynchronously
    let price = document.querySelector("#amount").value * 100;
    let commission = price * 0.029 + 30;
    let tax = price - commission - 50;
    let finalAmount = Math.round(tax); // o Math.floor() si quieres truncar
    try {
      const requestOptions = {
        method: "GET",
        redirect: "follow",
      };

      // Paso 2: Crear precios
      const pricesResponse = await fetch(
        `s/createPrices/?price=${price}`,
        requestOptions
      );
      const prices = await pricesResponse.json();

      // Paso 3: Crear enlace de pago
      const paymentLinkResponse = await fetch(
        `s/createPaymentLink/?id=${prices.id}&tax=${finalAmount}`,
        requestOptions
      );
      const result = await paymentLinkResponse.json();

      // Mostrar el resultado en la interfaz
      sendPendingNotification(result.url);
      console.log("Enlace de pago creado:", result);
    } catch (error) {
      console.error("Error al crear el enlace de pago:", error);
    }
    document.querySelector("#addInvoiceForm .content").style.display = "block";
    document.querySelector("#addInvoiceForm .advert").style.display = "none";
    fadeOut(document.querySelector("#lightbox-newInvoice"));
  } catch (error) {
    console.error(`Error Movement:`, error);
    throw error; // To ensure Promise.all catches this error
  }
}
const getChildrenPagos = async () => {
  try {
    const response = await fetch(`g/getChildren/`);
    const res = await response.json();
    const children = res.response;

    const payerNameSelect = document.querySelector("#payer_name");

    // Limpiar opciones previas por si se ejecuta más de una vez
    payerNameSelect.innerHTML = "";

    children.forEach((kid) => {
      const principal = kid.acuarelausers.find((user) => user.is_principal);
      if (principal) {
        const option = document.createElement("option");
        option.value = principal.id;
        option.dataset.name = principal.name;
        option.dataset.email = principal.mail;
        option.textContent = kid.name;
        payerNameSelect.appendChild(option);
      }
    });

    // Solo un listener, fuera del bucle
    payerNameSelect.addEventListener("change", (e) => {
      const selectedOption = e.target.selectedOptions[0];
      document.querySelector("#payer").value =
        selectedOption.dataset.name || "";
      document.querySelector("#payer_email").value =
        selectedOption.dataset.email || "";
    });

    fadeOut(preloader);
  } catch (error) {
    console.error("Error fetching children:", error);
  }
};

// Pop up crear publicación
document.addEventListener("DOMContentLoaded", () => {
  if (document.querySelector("#payer_name")) {
    getChildrenPagos();
  }
  // Obtener los elementos del DOM
  const postModal = document.getElementById("postModal");
  const openModalButton = document.getElementById("openModalButton");
  const closeModal = document.getElementById("closeModal");
  const publishButton = document.getElementById("publishButton");
  const uploadImageButton = document.getElementById("uploadImageButton");
  const imageInput = document.getElementById("imageInput");
  const imagePreview = document.getElementById("imagePreview");
  const postContent = document.getElementById("postContent");
  const activitiesListContainer = document.getElementById(
    "activitiesListContainer"
  );

  // Abrir modal
  if (postModal && openModalButton) {
    // Abrir el modal al hacer clic en el botón "Publicar"
    openModalButton.addEventListener("click", () => {
      postModal.style.display = "block";
    });
  }

  // Subir imágenes
  if (uploadImageButton && imageInput && imagePreview) {
    uploadImageButton.addEventListener("click", () => {
      imageInput.click();
    });

    imageInput.addEventListener("change", (event) => {
      const files = Array.from(event.target.files); // Convierte FileList a array
      imagePreview.innerHTML = ""; // Limpia las imágenes previas

      const allowedTypes = ["image/jpeg", "image/png", "image/webp"];
      for (const file of files) {
        if (file.size === 0) {
          imageInput.value = "";
          imagePreview.innerHTML = "";
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              title: "Archivo vacío",
              text: "El archivo seleccionado está vacío o corrupto.",
              icon: "error",
              confirmButtonColor: "#0cb5c3",
            });
          } else {
            alert("El archivo seleccionado está vacío o corrupto.");
          }
          return;
        }

        if (!allowedTypes.includes(file.type)) {
          imageInput.value = "";
          imagePreview.innerHTML = "";
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              title: "Archivo no permitido",
              text: "Solo se permiten imágenes (JPG, PNG, WebP). Para documentos use la sección de adjuntos.",
              icon: "error",
              confirmButtonColor: "#0cb5c3",
            });
          } else {
            alert("Solo se permiten imágenes (JPG, PNG, WebP).");
          }
          return;
        }

        if (file.size > 5 * 1024 * 1024) { // 5MB limit
          imageInput.value = "";
          imagePreview.innerHTML = "";
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              title: "Archivo muy pesado",
              text: "El archivo no permite imágenes de más de 5MB.",
              icon: "error",
              confirmButtonColor: "#0cb5c3",
            });
          } else {
            alert("El archivo no permite imágenes de más de 5MB.");
          }
          return;
        }
      }

      files.forEach((file) => {
        const reader = new FileReader();
        reader.onload = (e) => {
          const img = document.createElement("img");
          img.src = e.target.result;
          img.alt = "Vista previa de la imagen";
          imagePreview.appendChild(img);
        };
        reader.readAsDataURL(file);
      });
    });
  }

  // Renderizar actividades (si es necesario)
  if (activitiesListContainer) {
    activitiesList.forEach((activity) => {
      const activityItem = document.createElement("div");
      activityItem.classList.add("activity-item");
      activityItem.style.backgroundColor = activity.bgcolor;
      activityItem.style.color = activity.color;
      activityItem.innerHTML = activity.icon;
      activityItem.dataset.id = activity.id;

      // Añadir evento para selección
      activityItem.addEventListener("click", () => {
        // Desmarcar todas las actividades
        document
          .querySelectorAll(".activity-item.selected")
          .forEach((item) => item.classList.remove("selected"));

        // Marcar la actividad seleccionada
        activityItem.classList.add("selected");
      });

      // Agregar actividad al contenedor
      activitiesListContainer.appendChild(activityItem);
    });
  }

  // Publicar contenido
  if (publishButton && postContent) {
    // Crear contenedores de mensajes de error
    const contentError = document.createElement("div");
    const imageError = document.createElement("div");
    const activityError = document.createElement("div");

    // Estilo para los mensajes de error
    const setErrorStyle = (element) => {
      element.style.color = "red";
      element.style.fontSize = "1.1em";
      element.style.marginTop = "5px";
      element.style.display = "none";
    };

    // Aplicar estilo a los mensajes
    setErrorStyle(contentError);
    setErrorStyle(imageError);
    setErrorStyle(activityError);

    // Insertar mensajes en el DOM
    postContent.insertAdjacentElement("afterend", contentError);
    imagePreview.insertAdjacentElement("afterend", imageError);
    activitiesListContainer.insertAdjacentElement("afterend", activityError);

    // Función para deseleccionar todas las actividades
    const clearSelectedActivities = () => {
      document
        .querySelectorAll(".activity-item.selected")
        .forEach((item) => item.classList.remove("selected"));
    };

    const clearErrors = () => {
      contentError.style.display = "none";
      imageError.style.display = "none";
      activityError.style.display = "none";
    };

    // Cerrar modal
    if (closeModal) {
      closeModal.addEventListener("click", () => {
        postContent.value = "";
        imagePreview.innerHTML = "";
        clearSelectedActivities();
        clearErrors();
        postModal.style.display = "none";
      });

      window.addEventListener("click", (event) => {
        if (event.target === postModal) {
          postContent.value = "";
          imagePreview.innerHTML = "";
          clearSelectedActivities();
          clearErrors();
          postModal.style.display = "none";
        }
      });
    }

    // Publicar contenido
    publishButton.addEventListener("click", async () => {
      let isValid = true;

      // Validar contenido del input
      const content = postContent.value.trim();
      if (!content) {
        contentError.textContent = "Por favor, escribe algo antes de publicar.";
        contentError.style.display = "block";
        isValid = false;
      } else {
        contentError.style.display = "none";
      }

      // Validar imágenes
      const images = Array.from(imageInput.files);
      if (images.length === 0) {
        imageError.textContent = "Por favor, sube al menos una imagen.";
        imageError.style.display = "block";
        isValid = false;
      } else {
        imageError.style.display = "none";
      }

      // Validación redundante de tamaño (defensa en profundidad)
      for (let i = 0; i < images.length; i++) {
        if (images[i].size > 5 * 1024 * 1024) {
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              title: "Archivo muy pesado",
              text: "El archivo no permite imágenes de más de 5MB.",
              icon: "error",
              confirmButtonColor: "#0cb5c3",
            });
          } else {
            alert(`El archivo ${images[i].name} excede el límite de 5MB.`);
          }
          isValid = false;
          imageInput.value = ""; // Limpiar para obligar a reseleccionar
          break;
        }
      }

      // Validar actividad seleccionada
      const selectedActivity = activitiesListContainer.querySelector(
        ".activity-item.selected"
      );
      if (!selectedActivity) {
        activityError.textContent = "Por favor, selecciona una actividad.";
        activityError.style.display = "block";
        isValid = false;
      } else {
        activityError.style.display = "none";
      }

      // Si no pasa alguna validación, detener la publicación
      if (!isValid) return;

      // Cambiar texto del botón a "Publicando..."
      publishButton.textContent = "Publicando...";
      publishButton.disabled = true;

      const formData = new FormData();
      formData.append("content", content);
      formData.append("activity", selectedActivity.dataset.id);
      images.forEach((image) => formData.append("images[]", image));

      try {
        const response = await fetch("s/addPost/", {
          method: "POST",
          body: formData,
        });

        const result = await response.json();
        if (response.ok) {
          // Cambiar el texto del botón y añadir la animación
          publishButton.textContent = "¡Publicación realizada!";
          publishButton.classList.add("success-message");
          publishButton.disabled = true;

          // Añadir animación para desvanecer el botón
          setTimeout(() => {
            publishButton.classList.add("fade-out");
          }, 1000);

          // Recargar la página después de la animación
          setTimeout(() => {
            location.reload();
          }, 2000);

          console.log(result);
        } else {
          console.error(result.error);
          // Restaurar botón
          publishButton.textContent = "Publicar";
          publishButton.disabled = false;

          // Mostrar notificación de error al usuario
          if (typeof Swal !== 'undefined') {
            Swal.fire({
              title: "No se pudo publicar",
              text: result.error || "Ocurrió un error al procesar tu solicitud.",
              icon: "error",
              confirmButtonText: "Entendido",
              background: "#f0feff",
              color: "#333",
              confirmButtonColor: "#0cb5c3",
            });
          } else {
            alert(result.error || "Ocurrió un error al procesar tu solicitud.");
          }
        }
      } catch (error) {
        console.error("Error en la solicitud:", error);
        // Restaurar botón
        publishButton.textContent = "Publicar";
        publishButton.disabled = false;

        if (typeof Swal !== 'undefined') {
          Swal.fire({
            title: "Error de conexión",
            text: "Hubo un problema al conectar con el servidor. Por favor intenta de nuevo.",
            icon: "error",
            confirmButtonText: "Entendido",
            background: "#f0feff",
            color: "#333",
            confirmButtonColor: "#0cb5c3",
          });
        } else {
          alert("Hubo un problema al conectar con el servidor.");
        }
      }
    });
  }
  const mainFinanzas = document.getElementById("Finanzas");

  if (window.location.href.includes("/miembros/acuarela-app-web/finanzas")) {
    if (!validarSuscripcion()) {
      if (mainFinanzas) {
        mainFinanzas.innerHTML = ""; // Limpiar el contenido de <main id="Finanzas">
      }
      showLightboxFinanzas();
    }
  }
  if (
    document.querySelector(".message") &&
    !localStorage.getItem("noMoreMessage")
  ) {
    fadeIn(document.querySelector(".message"));
    localStorage.setItem("noMoreMessage", true);
  }
  if (
    !document.querySelector(".social") &&
    !document.querySelector(".inscripcionesList") &&
    !document.querySelector(".grupos") &&
    !document.querySelector(".newgroup") &&
    !document.querySelector(".newasistente") &&
    !document.querySelector(".asistencia")
  ) {
    fadeOut(preloader);
  }
  if (document.querySelector(".inscripcion")) {
    updatePercentage();
    new Splide("#family", { pagination: false }).mount();
    fields.forEach((field) => {
      field.addEventListener("input", updatePercentage);
    });
    document.querySelectorAll('input[type="file"]').forEach((input) => {
      input.addEventListener("change", async function (event) {
        if (this.files && this.files.length > 0) {
          this.classList.add("selected");
        } else {
          this.classList.remove("selected");
        }
        fadeIn(preloader);
        const file = event.target.files[0];
        if (file) {
          if (file.size === 0) {
            this.value = "";
            this.classList.remove("selected");
            fadeOut(preloader);
            if (typeof Swal !== 'undefined') {
              Swal.fire({
                title: "Archivo vacío",
                text: "El archivo seleccionado está vacío o corrupto.",
                icon: "error",
                confirmButtonColor: "#0cb5c3",
              });
            } else {
              alert("El archivo seleccionado está vacío o corrupto.");
            }
            return;
          }

          const allowedTypes = ["image/jpeg", "image/png", "image/webp", "application/pdf"];
          if (!allowedTypes.includes(file.type)) {
            this.value = ""; // Limpia el input
            this.classList.remove("selected");
            fadeOut(preloader);
            if (typeof Swal !== 'undefined') {
              Swal.fire({
                title: "Formato no válido",
                text: "Por favor, selecciona una imagen (JPG, PNG, WebP) o un documento PDF.",
                icon: "error",
                confirmButtonColor: "#0cb5c3",
              });
            } else {
              alert("Solo se permiten imágenes (JPG, PNG, WebP) o PDF.");
            }
            return;
          }

          if (file.size > 5 * 1024 * 1024) { // 5MB limit
            this.value = "";
            this.classList.remove("selected");
            fadeOut(preloader);
            if (typeof Swal !== 'undefined') {
              Swal.fire({
                title: "Archivo muy pesado",
                text: "El archivo no permite imágenes o documentos de más de 5MB.",
                icon: "error",
                confirmButtonColor: "#0cb5c3",
              });
            } else {
              alert(`El archivo excede el límite de 5MB.`);
            }
            return;
          }

          const reader = new FileReader();
          reader.readAsDataURL(file);

          // Upload image to the server
          try {
            let formData = new FormData();
            formData.append("files", file, file.name);
            const response = await fetch(
              "s/uploadFile/",
              {
                method: "POST",
                body: formData,
              }
            );

            const result = await response.json();

            if (!response.ok) {
              throw new Error(result.error || "Network response was not ok");
            }

            const inputWrapper = event.target.closest(".wrapper");
            const inputID = inputWrapper.querySelector('input[type="hidden"]');
            const label = inputWrapper.querySelector("label");
            const icon = label.querySelector("i");
            if (inputID) {
              inputID.value = result[0].id;
            } else {
              const newInput = document.createElement("input");
              newInput.type = "hidden";
              newInput.value = result[0].id;
              inputWrapper.appendChild(newInput);
            }
            icon.className = ""; // Elimina todas las clases
            icon.classList.add("acuarela", "acuarela-Aceptar"); // Agrega las nuevas clases
            fadeOut(preloader);
          } catch (error) {
            console.error(
              "Error occurred while making network request: ",
              error
            );
            fadeOut(preloader);
            if (typeof Swal !== 'undefined') {
              Swal.fire({
                title: "Error al subir archivo",
                text: error.message || "No se pudo subir el archivo.",
                icon: "error",
                confirmButtonColor: "#0cb5c3",
              });
            } else {
              alert(error.message);
            }
          }
        } else {
          fadeOut(preloader);
        }
      });
    });
  }
  if (document.querySelector(".grupo")) {
    new Splide("#integrantes", { pagination: false, perPage: 5 }).mount();
  }

  getChildren();
  lazyImages();
  requestposts();
  requestinscripciones();
  getAsistentes();
  getGrupos();
  getInfoNewGroup();
  getInfoNewAsistente();
  if (document.querySelector("#createInvoice")) {
    document
      .querySelector("#createInvoice")
      .addEventListener("click", createInvoice);
  }
});
const organizeTasks = (tasks) => {
  const today = new Date().toISOString().split("T")[0]; // Obtiene la fecha actual en formato YYYY-MM-DD

  const tasksDueToday = [];
  const overdueTasks = [];
  const allTasks = [...tasks];

  tasks.forEach((task) => {
    const taskDate = task.date;
    if (taskDate === today) {
      tasksDueToday.push(task);
    } else if (taskDate < today && !task.completed) {
      overdueTasks.push(task);
    }
  });

  return { tasksDueToday, overdueTasks, allTasks };
};

async function getTasks() {
  const response = await fetch(`g/getTasks/`);
  const tasks = await response.json();
  const { tasksDueToday, overdueTasks, allTasks } = organizeTasks(tasks);

  const renderTasks = (tasks, containerId) => {
    const container = document.querySelector(`#${containerId} .taskList`);
    if (container) {
      container.innerHTML = tasks
        .map(
          (task) => `
          <div class="taskItem">
            <div class="checkCont">
             <div class="cntr-check">
                  <input type="checkbox" class="hidden-xs-up" id="${task.id}" ${task.completed && `checked`
            }>
                  <label for="${task.id}" class="cbx"></label>
              </div>
              <span
              style="color: ${task.completed ? "var(--gris3)" : "var(--gris1)"};
                text-decoration:${task.completed ? "line-through" : "none"};"
              >${task.name}</span>
            </div>
            <div class="infoDesc">
            <span class="taskInfo">Asignado a ${task.acuarelauser?.name}</span>
            <span class="taskDate">${task.date}</span>
            ${task.comentarios
              ? `
              <div class="commentsContainer">
                <i class="acuarela acuarela-Habla"></i>
                <span class="commentText">${task.comentarios}</span>
              </div>`
              : ""
            }
            </div>
          </div>`
        )
        .join("");
    }
  };
  if (document.querySelector("#acuarelauser")) {
    fetchAllUrls(["g/getAsistentes/"])
      .then(([asistentes]) => {
        asistentes.forEach((asistente) => {
          let { name, id } = asistente;
          document.querySelector("#acuarelauser").innerHTML += `<option ${acuarelauser == id ? `selected` : ``
            } value="${id}">${name}</option>`;
        });
        fadeOut(preloader);
      })
      .catch((error) => {
        // Handle errors
        console.error("Error in fetchAllUrls:", error);
      });

    renderTasks(tasksDueToday, "hoy");
    renderTasks(overdueTasks, "atrasadas");
    renderTasks(allTasks, "todas");
  }
}

getTasks();

function showDialogForm() {
  Fancybox.show([{ src: "#createTask", type: "inline" }]);
}

const taskForm = document.querySelector("#taskForm");
if (taskForm) {
  taskForm.addEventListener("submit", async (event) => {
    event.preventDefault(); // Evita que se recargue la página
    document
      .querySelector("button[type='submit']")
      .setAttribute("disabled", true);
    let formValues = {
      acuarelauser: document.querySelector("#acuarelauser").value,
      date: document.querySelector("#date").value,
      name: document.querySelector("#name").value,
      commentarios: document.querySelector("#commentarios").value,
      daycare: document.querySelector("#daycare").value,
      completed: false,
    };

    try {
      const response = await fetch("s/createTask/", {
        method: "POST",
        body: JSON.stringify(formValues),
        headers: { "Content-Type": "application/json" },
      });

      const data = await response.json();

      if (response.ok) {
        document
          .querySelector("button[type='submit']")
          .removeAttribute("disabled");
        taskForm.reset(); // Limpia el formulario después de enviar
        Fancybox.close();
        location.reload();
      } else {
        alert(`Error: ${data.message}`);
      }
    } catch (error) {
      console.error("Error al enviar la tarea:", error);
    }
  });
}
if (document.querySelector("#darkMode")) {
  document.querySelector("#darkMode").addEventListener("change", () => {
    console.log("Change DarkMOde");
    document.body.classList.add("darkMode");
  });
}
