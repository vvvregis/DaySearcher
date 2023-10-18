<?php

use \Exception;

class DayWeekCounter
{
    //@TODO В дальнейшем я бы покрыл класс юнит тестами и добавил новые классы для исключений
    private array $correctDays = [
        'Sunday',
        'Monday',
        'Tuesday',
        'Wednesday',
        'Thursday',
        'Friday',
        'Saturday',
    ];

    const NOT_VALID_DAY_ERROR = 'Day is not valid';
    const NOT_EXPECTED_ERROR = 'Something wrong';
    const NOT_VALID_DATE_ERROR = 'Date is not Valid';
    const DAY_IN_SECONDS = 86400;

    /**
     * Ожидает дату в формате (Y-m-d)
     * @param string $startDate
     * @param string $endDate
     * @param string $day
     * @return int
     * @throws Exception
     */
    public function calc(string $startDate, string $endDate, string $day = 'Tuesday'): int
    {
        try {
            $this->validateDay($day);
            $this->validateDate($startDate, $endDate);
            return $this->getFirstNeedDay($this->dateToSec($startDate), $this->dateToSec($endDate), $day);
        } catch (Exception $exception) {
            throw new Exception($exception->getMessage());
        }
    }

    /**
     * Валидирует день
     * @param string $day
     * @return void
     * @throws Exception
     */
    private function validateDay(string $day)
    {
        if (!in_array($day, $this->correctDays)) {
            throw new Exception(self::NOT_VALID_DAY_ERROR);
        }
    }

    /**
     * Валидирует дату
     * @param $startDate
     * @param $endDate
     * @return void
     * @throws \Exception
     */
    private function validateDate($startDate, $endDate)
    {
        if ($startDate > $endDate) {
            throw new Exception(self::NOT_VALID_DATE_ERROR);
        }
    }

    /**
     * Находит первый нужный день
     * @param int $startDateSec
     * @param int $endDateSec
     * @param string $day
     * @return int
     * @throws \Exception
     */
    private function getFirstNeedDay(int $startDateSec, int $endDateSec, string $day): int
    {
        for ($i = 0; $i <= 6; $i++) {
            $dayInSec = $i * self::DAY_IN_SECONDS;
            if (date('l', $startDateSec + $dayInSec) == $day) {
                return $this->getDayCountFromSec($startDateSec + $dayInSec, $endDateSec);
            }
        }

        throw new Exception(self::NOT_EXPECTED_ERROR);
    }

    /**
     * Рассчитывает количество нужных дней между датами в секундах
     * @param int $startDateSec
     * @param int $endDateSec
     * @return int
     */
    private function getDayCountFromSec(int $startDateSec, int $endDateSec): int
    {
        return floor(($endDateSec - $startDateSec) / (7 * self::DAY_IN_SECONDS));
    }

    /**
     * Переводит дату в секунды
     * @param string $date
     * @return int
     */
    private function dateToSec(string $date): int
    {
        return strtotime($date);
    }
}
