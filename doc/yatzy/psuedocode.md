INIT new game
Set numberOfRounds to 1
Set totalSum to 0
WHILE numberOfRounds are less or equal to 6
    INIT new round
    Set throw to 0
    WHILE number of throws are less then 3
        let player choose which die to throw
        INCREMENT throw
    END WHILE
    FOR each dice
        IF dice value is equal to numberOfRounds
            ADD dice value to totalSum
        END IF
    INCREMENT numberOfRounds
END WHILE

IF total sum is greater then or equal to 63 THEN
    add bonus of 50 to total sum
ENDIf
present result
