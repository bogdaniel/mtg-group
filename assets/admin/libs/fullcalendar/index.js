import { globalPlugins } from '@fullcalendar/core/index.javascript';
export * from '@fullcalendar/core/index.javascript';
import interactionPlugin__default from '@fullcalendar/interaction/index.javascript';
export * from '@fullcalendar/interaction/index.javascript';
import dayGridPlugin from '@fullcalendar/daygrid/index.javascript';
import timeGridPlugin from '@fullcalendar/timegrid/index.javascript';
import listPlugin from '@fullcalendar/list/index.javascript';
import multiMonthPlugin from '@fullcalendar/multimonth/index.javascript';

globalPlugins.push(interactionPlugin__default, dayGridPlugin, timeGridPlugin, listPlugin, multiMonthPlugin);
