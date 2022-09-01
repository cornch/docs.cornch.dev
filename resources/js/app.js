import Alpine from 'alpinejs'
import dayjs from 'dayjs'

import relativeTime from 'dayjs/plugin/relativeTime'
import utc from 'dayjs/plugin/utc'

dayjs.extend(relativeTime)
dayjs.extend(utc)

window.dayjs = dayjs

Alpine.start()
