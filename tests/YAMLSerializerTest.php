<?php
namespace FinanCalc\Utils\Serializers;

use FinanCalc\FinanCalc;
use Symfony\Component\Yaml\Yaml;

class YAMLSerializerTest extends \PHPUnit_Framework_TestCase
{
    // we will test the serializer on the most complex class with nested elements
    // the example is the same as in the DebtAmortizatorTest
    private $debtAmortizatorFactory;

    public function testYAMLSerializer()
    {
        $yaml_output = $this
            ->debtAmortizatorFactory
            ->getSerializedResult(new YAMLSerializer());

        $yamlObject = YAML::parse($yaml_output);

        // WE WILL TEST EACH AND EVERY PROPERTY OF THIS OBJECT

        // Debt principal
        $this->assertEquals(
            "40000",
            $yamlObject["debtPrincipal"]
        );
        // Debt number of compounding periods
        $this->assertEquals(
            "6",
            $yamlObject["debtNoOfCompoundingPeriods"]
        );
        // Debt length period
        $this->assertEquals(
            "1",
            $yamlObject["debtPeriodLength"]["years"]
        );
        $this->assertEquals(
            "12",
            $yamlObject["debtPeriodLength"]["months"]
        );
        $this->assertEquals(
            "360",
            $yamlObject["debtPeriodLength"]["days"]
        );
        // Debt interest
        $this->assertEquals(
            "0.12",
            $yamlObject["debtInterest"]
        );
        // Debt discount factor
        $this->assertEquals(
            "0.89",
            $this->round2DP($yamlObject["debtDiscountFactor"])
        );
        // Debt duration
        $this->assertEquals(
            "6",
            $yamlObject["debtDuration"]["years"]
        );
        $this->assertEquals(
            "72",
            $yamlObject["debtDuration"]["months"]
        );
        $this->assertEquals(
            "2160",
            $yamlObject["debtDuration"]["days"]
        );
        // Debt amount of single repayment
        $INDIVIDUAL_REPAYMENT = "9729.03";
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($yamlObject["debtSingleRepayment"])
        );
        // Debt repayments (principal part, interest part, total = principal part + interest part)
        $this->assertEquals(
            "4929.03",
            $this->round2DP($yamlObject["debtRepayments"]["1"]["principalAmount"])
        );
        $this->assertEquals(
            "4800.00",
            $this->round2DP($yamlObject["debtRepayments"]["1"]["interestAmount"])
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($yamlObject["debtRepayments"]["1"]["totalAmount"])
        );

        $this->assertEquals(
            "5520.51",
            $this->round2DP($yamlObject["debtRepayments"]["2"]["principalAmount"])
        );
        $this->assertEquals(
            "4208.52",
            $this->round2DP($yamlObject["debtRepayments"]["2"]["interestAmount"])
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($yamlObject["debtRepayments"]["2"]["totalAmount"])
        );

        $this->assertEquals(
            "6182.97",
            $this->round2DP($yamlObject["debtRepayments"]["3"]["principalAmount"])
        );
        $this->assertEquals(
            "3546.06",
            $this->round2DP($yamlObject["debtRepayments"]["3"]["interestAmount"])
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($yamlObject["debtRepayments"]["3"]["totalAmount"])
        );

        $this->assertEquals(
            "6924.93",
            $this->round2DP($yamlObject["debtRepayments"]["4"]["principalAmount"])
        );
        $this->assertEquals(
            "2804.10",
            $this->round2DP($yamlObject["debtRepayments"]["4"]["interestAmount"])
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($yamlObject["debtRepayments"]["4"]["totalAmount"])
        );

        $this->assertEquals(
            "7755.92",
            $this->round2DP($yamlObject["debtRepayments"]["5"]["principalAmount"])
        );
        $this->assertEquals(
            "1973.11",
            $this->round2DP($yamlObject["debtRepayments"]["5"]["interestAmount"])
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($yamlObject["debtRepayments"]["5"]["totalAmount"])
        );

        $this->assertEquals(
            "8686.63",
            $this->round2DP($yamlObject["debtRepayments"]["6"]["principalAmount"])
        );
        $this->assertEquals(
            "1042.4",
            $this->round2DP($yamlObject["debtRepayments"]["6"]["interestAmount"])
        );
        $this->assertEquals(
            $INDIVIDUAL_REPAYMENT,
            $this->round2DP($yamlObject["debtRepayments"]["6"]["totalAmount"])
        );
    }

    /**
     * @param $roundedObject
     * @return float
     */
    private function round2DP($roundedObject)
    {
        return round((float)$roundedObject, 2);
    }

    protected function setUp()
    {
        require_once dirname(__FILE__) . '/../vendor/uruba/financalc/src/FinanCalc.php';
        require_once dirname(__FILE__) . '/../src/YAMLSerializer.php';

        $this->debtAmortizatorFactory = FinanCalc
            ::getInstance()
            ->getFactory('DebtAmortizatorFactory')
            ->newYearlyDebtAmortization(
                40000,
                6,
                0.12);

        parent::setUp();
    }
}
