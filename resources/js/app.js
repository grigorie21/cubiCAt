import {createApp} from 'vue'
// import {createRouter, createWebHashHistory} from "vue-router"
// import {createStore} from 'vuex'
import "primeflex/primeflex.css";
import "primevue/resources/themes/saga-blue/theme.css";
import "primevue/resources/primevue.min.css";
import "primeicons/primeicons.css";
import Dropdown from 'primevue/dropdown';
import PrimeVue from "primevue/config";
import TabView from "primevue/tabview";
import TabPanel from "primevue/tabpanel";
import Button from "primevue/button";
import InputText from 'primevue/inputtext';
import Panel from 'primevue/panel';
import Card from 'primevue/card';
import Message from 'primevue/message';
import SelectButton from 'primevue/selectbutton';
import InputSwitch from 'primevue/inputswitch';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import ColumnGroup from 'primevue/columngroup'; //optional for column grouping
import MegaMenu from 'primevue/megamenu';
import Menubar from 'primevue/menubar';
import Textarea from 'primevue/textarea';
import Toolbar from "primevue/toolbar";
import FileUpload from "primevue/fileupload";
import Rating from "primevue/rating";
import Dialog from "primevue/dialog";
import RadioButton from "primevue/radiobutton";
import InputNumber from "primevue/inputnumber";
import Toast from "primevue/toast";
import ToastService from "primevue/toastservice";
import Tag from 'primevue/tag';
import Index from './Index.vue'
// import Auth from './Pages/Auth/Index2.vue'
// import App from './Pages/Auth/Index2.vue'
import ProgressSpinner from 'primevue/progressspinner';
import Password from 'primevue/password';
import Divider from 'primevue/divider';
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
// import store from './Store/index2';
import MultiSelect from 'primevue/multiselect';
import Listbox from 'primevue/listbox';
import Chip from 'primevue/chip';
import Calendar from 'primevue/calendar';
// import FullCalendar from 'primevue/fullcalendar';
// import { format, formatDistance, formatRelative, subDays } from 'date-fns'
import axios from 'axios'
// import VueAxios from 'vue-axios'
import InputMask from 'primevue/inputmask';

// const routes = [
//     {path: '/', name: 'calendar',component: () => import("./Pages/Admin/Calendar/Index.vue")},
// ];

// const router = createRouter({
//     // mode: 'history',
//     history: createWebHashHistory(),
//     // history: createWebHistory(),
// });

// export default router;

const app = createApp(Index);
app.use(PrimeVue, {ripple: true});
// app.use(router);


app.component("TabView", TabView);
app.component("TabPanel", TabPanel);
app.component("Button", Button);
app.component("Dropdown", Dropdown);
app.component("InputText", InputText);
app.component("Panel", Panel);
app.component("Card", Card);
app.component("Message", Message);
app.component("SelectButton", SelectButton);
app.component("InputSwitch", InputSwitch);
app.component("DataTable", DataTable);
app.component("Column", Column);
app.component("ColumnGroup", ColumnGroup);
app.component("MegaMenu", MegaMenu);
app.component("Menubar", Menubar);
app.component("Toolbar", Toolbar);
app.component("FileUpload", FileUpload);
app.component("Rating", Rating);
app.component("Dialog", Dialog);
app.component("RadioButton", RadioButton);
app.component("Textarea", Textarea);
app.component("InputNumber", InputNumber);
app.component("Toast", Toast);
app.component("Tag", Tag);
app.component("ProgressSpinner", ProgressSpinner);
app.component("Password", Password);
app.component("Divider", Divider);
app.component("Accordion", Accordion);
app.component("AccordionTab", AccordionTab);
app.component("MultiSelect", MultiSelect);
app.component("Listbox", Listbox);
app.component("Chip", Chip);
app.component("Calendar", Calendar);
app.component("InputMask", InputMask);

app.mount('#app');

