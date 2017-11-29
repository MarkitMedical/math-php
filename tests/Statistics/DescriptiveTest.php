<?php
namespace MathPHP\Tests\Statistics;

use MathPHP\Statistics\Descriptive;
use MathPHP\Exception;

class DescriptiveTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider dataProviderForRange
     */
    public function testRange(array $numbers, $range)
    {
        $this->assertEquals($range, Descriptive::range($numbers), '', 0.01);
    }

    /**
     * Data provider for range test
     * Data: [ [ numbers ], range ]
     */
    public function dataProviderForRange()
    {
        return [
            [ [ 1, 1, 1 ], 0 ],
            [ [ 1, 1, 2 ], 1 ],
            [ [ 1, 2, 1 ], 1 ],
            [ [ 8, 4, 3 ], 5 ],
            [ [ 9, 7, 8 ], 2 ],
            [ [ 13, 18, 13, 14, 13, 16, 14, 21, 13 ], 8 ],
            [ [ 1, 2, 4, 7 ], 6 ],
            [ [ 8, 9, 10, 10, 10, 11, 11, 11, 12, 13 ], 5 ],
            [ [ 6, 7, 8, 10, 12, 14, 14, 15, 16, 20 ], 14 ],
            [ [ 9, 10, 11, 13, 15, 17, 17, 18, 19, 23 ], 14 ],
            [ [ 12, 14, 16, 20, 24, 28, 28, 30, 32, 40 ], 28 ],
        ];
    }

    public function testRangeNullWhenEmptyArray()
    {
        $this->assertNull(Descriptive::range(array()));
    }

    /**
     * @dataProvider dataProviderForMidrange
     */
    public function testMidrange(array $numbers, $midrange)
    {
        $this->assertEquals($midrange, Descriptive::midrange($numbers), '', 0.01);
    }

    /**
     * Data provider for midrange test
     * Data: [ [ numbers ], range ]
     */
    public function dataProviderForMidrange()
    {
        return [
            [ [ 1, 1, 1 ], 1 ],
            [ [ 1, 1, 2 ], 1.5 ],
            [ [ 1, 2, 1 ], 1.5 ],
            [ [ 8, 4, 3 ], 5.5 ],
            [ [ 9, 7, 8 ], 8 ],
            [ [ 13, 18, 13, 14, 13, 16, 14, 21, 13 ], 17 ],
            [ [ 1, 2, 4, 7 ], 4 ],
            [ [ 8, 9, 10, 10, 10, 11, 11, 11, 12, 13 ], 10.5 ],
            [ [ 6, 7, 8, 10, 12, 14, 14, 15, 16, 20 ], 13 ],
            [ [ 9, 10, 11, 13, 15, 17, 17, 18, 19, 23 ], 16 ],
            [ [ 12, 14, 16, 20, 24, 28, 28, 30, 32, 40 ], 26 ],
        ];
    }

    public function testMidrangeNullWhenEmptyArray()
    {
        $this->assertNull(Descriptive::midrange(array()));
    }

    /**
     * @dataProvider dataProviderForPopulationVariance
     */
    public function testPopulationVariance(array $numbers, $variance)
    {
        $this->assertEquals($variance, Descriptive::populationVariance($numbers), '', 0.01);
    }

    /**
     * Data provider for population variance test
     * Data: [ [ numbers ], variance ]
     */
    public function dataProviderForPopulationVariance()
    {
        return [
            [ [ -10, 0, 10, 20, 30 ], 200 ],
            [ [ 8, 9, 10, 11, 12 ], 2 ],
            [ [ 600, 470, 170, 430, 300 ], 21704 ],
            [ [ -5, 1, 8, 7, 2], 21.84 ],
            [ [ 3, 7, 34, 25, 46, 7754, 3, 6 ], 6546331.937 ],
            [ [ 4, 6, 2, 2, 2, 2, 3, 4, 1, 3 ], 1.89 ],
            [ [ -3432, 5, 23, 9948, -74 ], 20475035.6 ],
        ];
    }

    public function testPopulationVarianceNullWhenEmptyArray()
    {
        $this->assertNull(Descriptive::populationVariance(array()));
    }

    /**
     * @dataProvider dataProviderForSampleVariance
     */
    public function testSampleVariance(array $numbers, $variance)
    {
        $this->assertEquals($variance, Descriptive::sampleVariance($numbers), '', 0.01);
    }

    /**
     * Data provider for sample variance test
     * Data: [ [ numbers ], variance ]
     */
    public function dataProviderForSampleVariance()
    {
        return [
            [ [ -10, 0, 10, 20, 30 ], 250 ],
            [ [ 8, 9, 10, 11, 12 ], 2.5 ],
            [ [ 600, 470, 170, 430, 300 ], 27130 ],
            [ [ -5, 1, 8, 7, 2 ], 27.3 ],
            [ [ 3, 7, 34, 25, 46, 7754, 3, 6 ], 7481522.21429 ],
            [ [ 4, 6, 2, 2, 2, 2, 3, 4, 1, 3 ], 2.1 ],
            [ [ -3432, 5, 23, 9948, -74 ], 25593794.5 ],
            [ [ 3, 21, 98, 203, 17, 9 ],  6219.9 ],
            [ [ 170, 300, 430, 470, 600 ], 27130 ],
            [ [ 1550, 1700, 900, 850, 1000, 950 ], 135416.66668 ],
            [ [ 1245, 1255, 1654, 1547, 1787, 1989, 1878, 2011, 2145, 2545, 2656 ], 210804.29090909063 ],
        ];
    }

    public function testSampleVarianceNullWhenEmptyArray()
    {
        $this->assertNull(Descriptive::sampleVariance(array()));
    }

    public function testSampleVarianceZeroWhenListContainsOnlyOneItem()
    {
        $this->assertEquals(0, Descriptive::sampleVariance([5]));
    }

    public function testVarianceExceptionDFLessThanZero()
    {
        $this->expectException(Exception\OutOfBoundsException::class);
        Descriptive::variance([1, 2, 3], -1);
    }

    /**
     * @dataProvider dataProviderForStandardDeviationUsingPopulationVariance
     */
    public function testStandardDeviationUsingPopulationVariance(array $numbers, $standard_deviation)
    {
        $this->assertEquals($standard_deviation, Descriptive::standardDeviation($numbers, true), '', 0.01);
    }

    /**
     * @dataProvider dataProviderForStandardDeviationUsingPopulationVariance
     */
    public function testSDeviationUsingPopulationVariance(array $numbers, $standard_deviation)
    {
        $this->assertEquals($standard_deviation, Descriptive::sd($numbers, true), '', 0.01);
    }

    /**
     * Data provider for standard deviation test
     * Data: [ [ numbers ], mean ]
     */
    public function dataProviderForStandardDeviationUsingPopulationVariance()
    {
        return [
            [ [ -10, 0, 10, 20, 30 ], 10 * sqrt(2) ],
            [ [ 8, 9, 10, 11, 12 ], sqrt(2) ],
            [ [ 600, 470, 170, 430, 300], 147.32 ],
            [ [ -5, 1, 8, 7, 2], 4.67 ],
            [ [ 3, 7, 34, 25, 46, 7754, 3, 6 ], 2558.580063 ],
            [ [ 4, 6, 2, 2, 2, 2, 3, 4, 1, 3 ], 1.374772708 ],
            [ [ -3432, 5, 23, 9948, -74 ], 4524.934872 ],
        ];
    }

    /**
     * @dataProvider dataProviderForStandardDeviationUsingSampleVariance
     */
    public function testStandardDeviationUsingSampleVariance(array $numbers, $standard_deviation)
    {
        $this->assertEquals($standard_deviation, Descriptive::standardDeviation($numbers), '', 0.01);
    }

    /**
     * @dataProvider dataProviderForStandardDeviationUsingSampleVariance
     */
    public function testSDeviationUsingSampleVariance(array $numbers, $standard_deviation)
    {
        $this->assertEquals($standard_deviation, Descriptive::sd($numbers), '', 0.01);
    }

    /**
     * Data provider for standard deviation using sample variance test
     * Data: [ [ numbers ], mean ]
     */
    public function dataProviderForStandardDeviationUsingSampleVariance()
    {
        return [
            [ [ 3, 21, 98, 203, 17, 9 ],  78.86634 ],
            [ [ 170, 300, 430, 470, 600 ], 164.7118696390761 ],
            [ [ 1550, 1700, 900, 850, 1000, 950 ], 367.99 ],
            [ [ 1245, 1255, 1654, 1547, 1787, 1989, 1878, 2011, 2145, 2545, 2656 ], 459.13 ],
        ];
    }

    public function testStandardDeviationNullWhenEmptyArray()
    {
        $this->assertNull(Descriptive::standardDeviation(array()));
    }

    public function testSDNullWhenEmptyArray()
    {
        $this->assertNull(Descriptive::sd(array()));
    }

    /**
     * @dataProvider dataProviderForMeanAbsoluteDeviation
     */
    public function testMeanAbsoluteDeviation(array $numbers, $mad)
    {
        $this->assertEquals($mad, Descriptive::meanAbsoluteDeviation($numbers), '', 0.01);
    }

    /**
     * Data provider for MAD (mean) test
     * Data: [ [ numbers ], mad ]
     */
    public function dataProviderForMeanAbsoluteDeviation()
    {
        return [
            [ [ 92, 83, 88, 94, 91, 85, 89, 90 ], 2.75 ],
            [ [ 2, 2, 3, 4, 14 ], 3.6 ],
        ];
    }

    public function testMeanAbsoluteDeviationNullWhenEmptyArray()
    {
        $this->assertNull(Descriptive::meanAbsoluteDeviation(array()));
    }

    /**
     * @dataProvider dataProviderForMedianAbsoluteDeviation
     */
    public function testMedianAbsoluteDeviation(array $numbers, $mad)
    {
        $this->assertEquals($mad, Descriptive::medianAbsoluteDeviation($numbers), '', 0.01);
    }

    /**
     * Data provider for MAD (median) test
     * Data: [ [ numbers ], mad ]
     */
    public function dataProviderForMedianAbsoluteDeviation()
    {
        return [
            [ [ 1, 1, 2, 2, 4, 6, 9 ], 1 ],
            [ [ 92, 83, 88, 94, 91, 85, 89, 90 ], 2 ],
            [ [ 2, 2, 3, 4, 14 ], 1 ],
        ];
    }

    public function testMedianAbsoluteDeviationNullWhenEmptyArray()
    {
        $this->assertNull(Descriptive::medianAbsoluteDeviation(array()));
    }

    /**
     * @dataProvider dataProviderForQuartilesExclusive
     */
    public function testQuartilesExclusive(array $numbers, array $quartiles)
    {
        $this->assertEquals($quartiles, Descriptive::quartilesExclusive($numbers));
    }

    public function dataProviderForQuartilesExclusive()
    {
        return [
            [
                [ 6, 7, 15, 36, 39, 40, 41, 42, 43, 47, 49],
                [ '0%' => 6, 'Q1' => 15, 'Q2' => 40, 'Q3' => 43, '100%' => 49, 'IQR' => 28 ],
            ],
            [
                [ 7, 15, 36, 39, 40, 41 ],
                [ '0%' => 7, 'Q1' => 15, 'Q2' => 37.5, 'Q3' => 40, '100%' => 41, 'IQR' => 25 ],
            ],
            [
                [ 0, 2, 2, 4, 5, 6, 7, 7, 8, 9, 34, 34, 43, 54, 54, 76, 234 ],
                [ '0%' => 0, 'Q1' => 4.5, 'Q2' => 8, 'Q3' => 48.5, '100%' => 234, 'IQR' => 44 ],
            ]
        ];
    }

    public function testQuartilesExclusiveEmptyWhenEmptyArray()
    {
        $this->assertEmpty(Descriptive::quartilesExclusive(array()));
    }

    /**
     * @dataProvider dataProviderForQuartilesInclusive
     */
    public function testQuartilesInclusive(array $numbers, array $quartiles)
    {
        $this->assertEquals($quartiles, Descriptive::quartilesInclusive($numbers));
    }

    public function dataProviderForQuartilesInclusive()
    {
        return [
            [
                [ 6, 7, 15, 36, 39, 40, 41, 42, 43, 47, 49],
                [ '0%' => 6, 'Q1' => 25.5, 'Q2' => 40, 'Q3' => 42.5, '100%' => 49, 'IQR' => 17 ],
            ],
            [
                [ 7, 15, 36, 39, 40, 41 ],
                [ '0%' => 7, 'Q1' => 15, 'Q2' => 37.5, 'Q3' => 40, '100%' => 41, 'IQR' => 25 ],
            ],
            [
                [ 0, 2, 2, 4, 5, 6, 7, 7, 8, 9, 34, 34, 43, 54, 54, 76, 234 ],
                [ '0%' => 0, 'Q1' => 5, 'Q2' => 8, 'Q3' => 43, '100%' => 234, 'IQR' => 38 ],
            ]
        ];
    }

    public function testQuartilesInclusiveEmptyWhenEmptyArray()
    {
        $this->assertEmpty(Descriptive::quartilesInclusive(array()));
    }

    /**
     * @dataProvider dataProviderForQuartiles
     */
    public function testQuartiles(array $numbers, string $method, array $quartiles)
    {
        $this->assertEquals($quartiles, Descriptive::quartiles($numbers, $method));
    }

    public function dataProviderForQuartiles()
    {
        return [
            [
                [ 6, 7, 15, 36, 39, 40, 41, 42, 43, 47, 49 ], 'Exclusive',
                [ '0%' => 6, 'Q1' => 15, 'Q2' => 40, 'Q3' => 43, '100%' => 49, 'IQR' => 28 ],
            ],
            [
                [ 7, 15, 36, 39, 40, 41 ], 'Exclusive',
                [ '0%' => 7, 'Q1' => 15, 'Q2' => 37.5, 'Q3' => 40, '100%' => 41, 'IQR' => 25 ],
            ],
            [
                [ 0, 2, 2, 4, 5, 6, 7, 7, 8, 9, 34, 34, 43, 54, 54, 76, 234 ], 'Exclusive',
                [ '0%' => 0, 'Q1' => 4.5, 'Q2' => 8, 'Q3' => 48.5, '100%' => 234, 'IQR' => 44 ],
            ],
            [
                [ 6, 7, 15, 36, 39, 40, 41, 42, 43, 47, 49 ], 'Inclusive',
                [ '0%' => 6, 'Q1' => 25.5, 'Q2' => 40, 'Q3' => 42.5, '100%' => 49, 'IQR' => 17 ],
            ],
            [
                [ 7, 15, 36, 39, 40, 41 ], 'Inclusive',
                [ '0%' => 7, 'Q1' => 15, 'Q2' => 37.5, 'Q3' => 40, '100%' => 41, 'IQR' => 25 ],
            ],
            [
                [ 0, 2, 2, 4, 5, 6, 7, 7, 8, 9, 34, 34, 43, 54, 54, 76, 234 ], 'Inclusive',
                [ '0%' => 0, 'Q1' => 5, 'Q2' => 8, 'Q3' => 43, '100%' => 234, 'IQR' => 38 ],
            ],
            [
                [ 6, 7, 15, 36, 39, 40, 41, 42, 43, 47, 49 ], 'Not_A_Real_Method_So_Default_Is_Used_Which_Is_Exclusive',
                [ '0%' => 6, 'Q1' => 15, 'Q2' => 40, 'Q3' => 43, '100%' => 49, 'IQR' => 28 ],
            ],
            [
                [ 7, 15, 36, 39, 40, 41 ], 'Not_A_Real_Method_So_Default_Is_Used_Which_Is_Exclusive',
                [ '0%' => 7, 'Q1' => 15, 'Q2' => 37.5, 'Q3' => 40, '100%' => 41, 'IQR' => 25 ],
            ],
            [
                [ 0, 2, 2, 4, 5, 6, 7, 7, 8, 9, 34, 34, 43, 54, 54, 76, 234 ], 'Not_A_Real_Method_So_Default_Is_Used_Which_Is_Exclusive',
                [ '0%' => 0, 'Q1' => 4.5, 'Q2' => 8, 'Q3' => 48.5, '100%' => 234, 'IQR' => 44 ],
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForIQR
     */
    public function testInterquartileRange(array $numbers, $IQR)
    {
        $this->assertEquals($IQR, Descriptive::interquartileRange($numbers));
    }

    /**
     * @dataProvider dataProviderForIQR
     */
    public function testIQR(array $numbers, $IQR)
    {
        $this->assertEquals($IQR, Descriptive::iqr($numbers));
    }

    public function dataProviderForIQR()
    {
        return [
            [ [ 6, 7, 15, 36, 39, 40, 41, 42, 43, 47, 49], 28 ],
            [ [ 7, 15, 36, 39, 40, 41 ], 25 ],
        ];
    }

    /**
     * @testCase     percentile
     * @dataProvider dataProviderForPercentile
     * @param        array $numbers
     * @param        float $percentile
     * @param        float $value
     */
    public function testPercentile(array $numbers, float $percentile, float $value)
    {
        $this->assertEquals($value, Descriptive::percentile($numbers, $percentile), '', 0.0000001);
    }

    /**
     * @return array
     */
    public function dataProviderForPercentile(): array
    {
        return [
            // Wikipedia
            [[15, 20, 35, 40, 50], 40, 29],
            [[1, 2, 3, 4], 75, 3.25],

            // numpy.percentile / Excel 2015 Mac
            // All int percentiles 0 - 100
            [[15, 20, 35, 40, 50], 0, 15],
            [[15, 20, 35, 40, 50], 1, 15.2],
            [[15, 20, 35, 40, 50], 2, 15.4],
            [[15, 20, 35, 40, 50], 3, 15.6],
            [[15, 20, 35, 40, 50], 4, 15.8],
            [[15, 20, 35, 40, 50], 5, 16.0],
            [[15, 20, 35, 40, 50], 6, 16.2],
            [[15, 20, 35, 40, 50], 7, 16.4],
            [[15, 20, 35, 40, 50], 8, 16.6],
            [[15, 20, 35, 40, 50], 9, 16.8],
            [[15, 20, 35, 40, 50], 10, 17.0],
            [[15, 20, 35, 40, 50], 11, 17.2],
            [[15, 20, 35, 40, 50], 12, 17.4],
            [[15, 20, 35, 40, 50], 13, 17.6],
            [[15, 20, 35, 40, 50], 14, 17.8],
            [[15, 20, 35, 40, 50], 15, 18.0],
            [[15, 20, 35, 40, 50], 16, 18.2],
            [[15, 20, 35, 40, 50], 17, 18.4],
            [[15, 20, 35, 40, 50], 18, 18.6],
            [[15, 20, 35, 40, 50], 19, 18.8],
            [[15, 20, 35, 40, 50], 20, 19.0],
            [[15, 20, 35, 40, 50], 21, 19.2],
            [[15, 20, 35, 40, 50], 22, 19.4],
            [[15, 20, 35, 40, 50], 23, 19.6],
            [[15, 20, 35, 40, 50], 24, 19.8],
            [[15, 20, 35, 40, 50], 25, 20.0],
            [[15, 20, 35, 40, 50], 26, 20.6],
            [[15, 20, 35, 40, 50], 27, 21.2],
            [[15, 20, 35, 40, 50], 28, 21.8],
            [[15, 20, 35, 40, 50], 29, 22.4],
            [[15, 20, 35, 40, 50], 30, 23.0],
            [[15, 20, 35, 40, 50], 31, 23.6],
            [[15, 20, 35, 40, 50], 32, 24.2],
            [[15, 20, 35, 40, 50], 33, 24.8],
            [[15, 20, 35, 40, 50], 34, 25.4],
            [[15, 20, 35, 40, 50], 35, 26.0],
            [[15, 20, 35, 40, 50], 36, 26.6],
            [[15, 20, 35, 40, 50], 37, 27.2],
            [[15, 20, 35, 40, 50], 38, 27.8],
            [[15, 20, 35, 40, 50], 39, 28.4],
            [[15, 20, 35, 40, 50], 40, 29.0],
            [[15, 20, 35, 40, 50], 41, 29.6],
            [[15, 20, 35, 40, 50], 42, 30.2],
            [[15, 20, 35, 40, 50], 43, 30.8],
            [[15, 20, 35, 40, 50], 44, 31.4],
            [[15, 20, 35, 40, 50], 45, 32.0],
            [[15, 20, 35, 40, 50], 46, 32.6],
            [[15, 20, 35, 40, 50], 47, 33.2],
            [[15, 20, 35, 40, 50], 48, 33.8],
            [[15, 20, 35, 40, 50], 49, 34.4],
            [[15, 20, 35, 40, 50], 50, 35.0],
            [[15, 20, 35, 40, 50], 51, 35.2],
            [[15, 20, 35, 40, 50], 52, 35.4],
            [[15, 20, 35, 40, 50], 53, 35.6],
            [[15, 20, 35, 40, 50], 54, 35.8],
            [[15, 20, 35, 40, 50], 55, 36.0],
            [[15, 20, 35, 40, 50], 56, 36.2],
            [[15, 20, 35, 40, 50], 57, 36.4],
            [[15, 20, 35, 40, 50], 58, 36.6],
            [[15, 20, 35, 40, 50], 59, 36.8],
            [[15, 20, 35, 40, 50], 60, 37.0],
            [[15, 20, 35, 40, 50], 61, 37.2],
            [[15, 20, 35, 40, 50], 62, 37.4],
            [[15, 20, 35, 40, 50], 63, 37.6],
            [[15, 20, 35, 40, 50], 64, 37.8],
            [[15, 20, 35, 40, 50], 65, 38.0],
            [[15, 20, 35, 40, 50], 66, 38.2],
            [[15, 20, 35, 40, 50], 67, 38.4],
            [[15, 20, 35, 40, 50], 68, 38.6],
            [[15, 20, 35, 40, 50], 69, 38.8],
            [[15, 20, 35, 40, 50], 70, 39.0],
            [[15, 20, 35, 40, 50], 71, 39.2],
            [[15, 20, 35, 40, 50], 72, 39.4],
            [[15, 20, 35, 40, 50], 73, 39.6],
            [[15, 20, 35, 40, 50], 74, 39.8],
            [[15, 20, 35, 40, 50], 75, 40.0],
            [[15, 20, 35, 40, 50], 76, 40.4],
            [[15, 20, 35, 40, 50], 77, 40.8],
            [[15, 20, 35, 40, 50], 78, 41.2],
            [[15, 20, 35, 40, 50], 79, 41.6],
            [[15, 20, 35, 40, 50], 80, 42.0],
            [[15, 20, 35, 40, 50], 81, 42.4],
            [[15, 20, 35, 40, 50], 82, 42.8],
            [[15, 20, 35, 40, 50], 83, 43.2],
            [[15, 20, 35, 40, 50], 84, 43.6],
            [[15, 20, 35, 40, 50], 85, 44.0],
            [[15, 20, 35, 40, 50], 86, 44.4],
            [[15, 20, 35, 40, 50], 87, 44.8],
            [[15, 20, 35, 40, 50], 88, 45.2],
            [[15, 20, 35, 40, 50], 89, 45.6],
            [[15, 20, 35, 40, 50], 90, 46.0],
            [[15, 20, 35, 40, 50], 91, 46.4],
            [[15, 20, 35, 40, 50], 92, 46.8],
            [[15, 20, 35, 40, 50], 93, 47.2],
            [[15, 20, 35, 40, 50], 94, 47.6],
            [[15, 20, 35, 40, 50], 95, 48.0],
            [[15, 20, 35, 40, 50], 96, 48.4],
            [[15, 20, 35, 40, 50], 97, 48.8],
            [[15, 20, 35, 40, 50], 98, 49.2],
            [[15, 20, 35, 40, 50], 99, 49.6],
            [[15, 20, 35, 40, 50], 100, 50.0],

            // Float percentiles
            [[15, 20, 35, 40, 50], 0.5, 15.1],
            [[15, 20, 35, 40, 50], 1.5, 15.299999999999999],
            [[15, 20, 35, 40, 50], 5.5, 16.100000000000001],
            [[15, 20, 35, 40, 50], 50.5, 35.099999999999994],
            [[15, 20, 35, 40, 50], 60.2, 37.039999999999999],
            [[15, 20, 35, 40, 50], 91.8, 46.719999999999999],
            [[15, 20, 35, 40, 50], 99.9, 49.960000000000008],

            // Edge case: one-element list
            [[5], 0, 5],
            [[5], 1, 5],
            [[5], 50.5, 5],
            [[5], 99, 5],
            [[5], 100, 5],

            // Two-element list
            [[2, 3], 0, 2],
            [[2, 3], 1, 2.01],
            [[2, 3], 50.5, 2.505],
            [[2, 3], 99, 2.9899999999999998],
            [[2, 3], 100, 3],

            // Big list
            [[1,2,3,4,5,6,7,8,9,9,8,7,6,5,4,3,2,1,2,3,4,5,6,7,8,9,1,2,3,4,5,6,7,8,9,9,9,9,9,9,9,9,8,9,8,9,8,9,8,7,6,5,4,3,2,1,2,3,4,3,4,3,4,5,6,7,8,7,8,7,8,9,0,0,9,0,9,8,7,6,5,4,3,2,1], 45.3, 5],

            // More random test cases
            [[3, 6, 7, 8, 8, 10, 13, 15, 16, 20], 0, 3.0 ],
            [[3, 6, 7, 8, 8, 10, 13, 15, 16, 20], 25, 7.25 ],
            [[3, 6, 7, 8, 8, 10, 13, 15, 16, 20], 50, 9.0 ],
            [[3, 6, 7, 8, 8, 10, 13, 15, 16, 20], 75, 14.5 ],
            [[3, 6, 7, 8, 8, 10, 13, 15, 16, 20], 100, 20.0 ],
            [[3, 6, 7, 8, 8, 9, 10, 13, 15, 16, 20], 0, 3.0 ],
            [[3, 6, 7, 8, 8, 9, 10, 13, 15, 16, 20], 25, 7.5 ],
            [[3, 6, 7, 8, 8, 9, 10, 13, 15, 16, 20], 50, 9.0 ],
            [[3, 6, 7, 8, 8, 9, 10, 13, 15, 16, 20], 75, 14.0 ],
            [[3, 6, 7, 8, 8, 9, 10, 13, 15, 16, 20], 100, 20.0 ],
        ];
    }

    /**
     * @testCase percentile throws an Exception\BadDataException if numbers is empty
     */
    public function testPercentileEmptyList()
    {
        $this->expectException(Exception\BadDataException::class);
        Descriptive::percentile([], 5);
    }

    /**
     * @testCase percentile throws an Exception\OutOfBoundsException if P is < 0
     */
    public function testPercentileOutOfLowerBoundsP()
    {
        $this->expectException(Exception\OutOfBoundsException::class);
        Descriptive::percentile([1, 2, 3], -4);
    }

    /**
     * @testCase percentile throws an Exception\OutOfBoundsException if P is > 100
     */
    public function testPercentileOutOfUpperBoundsP()
    {
        $this->expectException(Exception\OutOfBoundsException::class);
        Descriptive::percentile([1, 2, 3], 101);
    }

    /**
     * @dataProvider dataProviderForMidhinge
     */
    public function testMidhinge(array $numbers, $midhinge)
    {
        $this->assertEquals($midhinge, Descriptive::midhinge($numbers), '', 0.01);
    }

    public function dataProviderForMidhinge()
    {
        return [
            [ [1, 2, 3, 4, 5, 6], 3.5 ],
            [ [5, 5, 7, 8, 8, 11, 12, 12, 14, 15, 16, 19, 21, 22, 22, 26, 26, 26, 28, 29, 29, 32, 33, 34, 34, 34, 34, 35, 35, 37, 38, 38], 23.5],
            [ [36, 34, 21, 10, 20, 24, 31, 30, 30, 30, 30, 24, 30, 24, 39, 6, 32, 33, 33, 25, 26, 35, 8, 5, 30, 40, 9, 32, 25, 40, 24, 38], 28.5],
            [ [8, 10, 11, 12, 12, 13, 17, 18, 19, 19, 21, 23, 24, 24, 25, 25, 27, 27, 28, 28, 29, 29, 30, 30, 32, 33, 34, 35, 36, 37, 37, 40], 24.75 ],
        ];
    }

    /**
     * @dataProvider dataProviderForCoefficientOfVariation
     */
    public function testsCoefficientOfVariation(array $numbers, $cv)
    {
        $this->assertEquals($cv, Descriptive::coefficientOfVariation($numbers), '', 0.0001);
    }

    public function dataProviderForCoefficientOfVariation()
    {
        return [
            [ [1, 2, 3, 4, 5, 6 ,7, 8], 0.54433 ],
            [ [4, 7, 43, 12, 23, 76, 45, 3, 62, 23, 34, 44, 41], 0.70673 ],
            [ [3, 3, 3, 6, 6, 5, 9], 0.44721 ],
            [ [100, 100, 100], 0 ],
            [ [0, 10, 20, 30, 40], 0.7905 ],
            [ [32, 50, 68, 86, 104], 0.41852941176471 ],
        ];
    }

    public function testDescribePopulation()
    {
        $stats = Descriptive::describe([ 13, 18, 13, 14, 13, 16, 14, 21, 13 ], true);
        $this->assertTrue(is_array($stats));
        $this->assertArrayHasKey('n', $stats);
        $this->assertArrayHasKey('min', $stats);
        $this->assertArrayHasKey('max', $stats);
        $this->assertArrayHasKey('mean', $stats);
        $this->assertArrayHasKey('median', $stats);
        $this->assertArrayHasKey('mode', $stats);
        $this->assertArrayHasKey('range', $stats);
        $this->assertArrayHasKey('midrange', $stats);
        $this->assertArrayHasKey('variance', $stats);
        $this->assertArrayHasKey('sd', $stats);
        $this->assertArrayHasKey('cv', $stats);
        $this->assertArrayHasKey('mean_mad', $stats);
        $this->assertArrayHasKey('median_mad', $stats);
        $this->assertArrayHasKey('quartiles', $stats);
        $this->assertArrayHasKey('midhinge', $stats);
        $this->assertArrayHasKey('skewness', $stats);
        $this->assertArrayHasKey('ses', $stats);
        $this->assertArrayHasKey('kurtosis', $stats);
        $this->assertArrayHasKey('sek', $stats);
        $this->assertArrayHasKey('sem', $stats);
        $this->assertArrayHasKey('ci_95', $stats);
        $this->assertArrayHasKey('ci_99', $stats);
        $this->assertTrue(is_int($stats['n']));
        $this->assertTrue(is_numeric($stats['min']));
        $this->assertTrue(is_numeric($stats['max']));
        $this->assertTrue(is_numeric($stats['mean']));
        $this->assertTrue(is_numeric($stats['median']));
        $this->assertTrue(is_array($stats['mode']));
        $this->assertTrue(is_numeric($stats['range']));
        $this->assertTrue(is_numeric($stats['midrange']));
        $this->assertTrue(is_numeric($stats['variance']));
        $this->assertTrue(is_numeric($stats['sd']));
        $this->assertTrue(is_numeric($stats['cv']));
        $this->assertTrue(is_numeric($stats['mean_mad']));
        $this->assertTrue(is_numeric($stats['median_mad']));
        $this->assertTrue(is_array($stats['quartiles']));
        $this->assertTrue(is_numeric($stats['midhinge']));
        $this->assertTrue(is_numeric($stats['skewness']));
        $this->assertTrue(is_numeric($stats['ses']));
        $this->assertTrue(is_numeric($stats['kurtosis']));
        $this->assertTrue(is_numeric($stats['sek']));
        $this->assertTrue(is_numeric($stats['sem']));
        $this->assertTrue(is_array($stats['ci_95']));
        $this->assertTrue(is_array($stats['ci_99']));
    }

    public function testDescribeSample()
    {
        $stats = Descriptive::describe([ 13, 18, 13, 14, 13, 16, 14, 21, 13 ], false);
        $this->assertTrue(is_array($stats));
        $this->assertArrayHasKey('n', $stats);
        $this->assertArrayHasKey('min', $stats);
        $this->assertArrayHasKey('max', $stats);
        $this->assertArrayHasKey('mean', $stats);
        $this->assertArrayHasKey('median', $stats);
        $this->assertArrayHasKey('mode', $stats);
        $this->assertArrayHasKey('range', $stats);
        $this->assertArrayHasKey('midrange', $stats);
        $this->assertArrayHasKey('variance', $stats);
        $this->assertArrayHasKey('sd', $stats);
        $this->assertArrayHasKey('cv', $stats);
        $this->assertArrayHasKey('quartiles', $stats);
        $this->assertArrayHasKey('midhinge', $stats);
        $this->assertArrayHasKey('skewness', $stats);
        $this->assertArrayHasKey('ses', $stats);
        $this->assertArrayHasKey('kurtosis', $stats);
        $this->assertArrayHasKey('sek', $stats);
        $this->assertArrayHasKey('sem', $stats);
        $this->assertArrayHasKey('ci_95', $stats);
        $this->assertArrayHasKey('ci_99', $stats);
        $this->assertTrue(is_int($stats['n']));
        $this->assertTrue(is_numeric($stats['min']));
        $this->assertTrue(is_numeric($stats['max']));
        $this->assertTrue(is_numeric($stats['mean']));
        $this->assertTrue(is_numeric($stats['median']));
        $this->assertTrue(is_array($stats['mode']));
        $this->assertTrue(is_numeric($stats['range']));
        $this->assertTrue(is_numeric($stats['midrange']));
        $this->assertTrue(is_numeric($stats['variance']));
        $this->assertTrue(is_numeric($stats['sd']));
        $this->assertTrue(is_numeric($stats['cv']));
        $this->assertTrue(is_array($stats['quartiles']));
        $this->assertTrue(is_numeric($stats['midhinge']));
        $this->assertTrue(is_numeric($stats['skewness']));
        $this->assertTrue(is_numeric($stats['ses']));
        $this->assertTrue(is_numeric($stats['kurtosis']));
        $this->assertTrue(is_numeric($stats['sek']));
        $this->assertTrue(is_numeric($stats['sem']));
        $this->assertTrue(is_array($stats['ci_95']));
        $this->assertTrue(is_array($stats['ci_99']));
    }

    /**
     * @dataProvider dataProviderForFiveNumberSummary
     */
    public function testFiveNumberSummary(array $numbers, array $summary)
    {
        $this->assertEquals($summary, Descriptive::fiveNumberSummary($numbers), '', 0.0001);
    }

    public function dataProviderForFiveNumberSummary()
    {
        return [
            [
                [0, 0, 1, 2, 63, 61, 27, 13],
                ['min' => 0, 'Q1' => 0.5, 'median' => 7.5, 'Q3' => 44.0, 'max' => 63],
            ],
        ];
    }
}
