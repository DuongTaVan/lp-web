import dayjs from "dayjs";
const isoWeek = require('dayjs/plugin/isoWeek');
import "dayjs/locale/ja";
var timezone = require('dayjs/plugin/timezone');
var utc = require('dayjs/plugin/utc');
dayjs.extend(isoWeek);
dayjs.extend(timezone);
dayjs.extend(utc);
dayjs.locale("ja");

export default dayjs;