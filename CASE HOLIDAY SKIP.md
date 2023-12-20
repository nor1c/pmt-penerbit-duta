I have holidays table, with this schema
- date
- title

And I want to make a feature to count total of off work-days/holidays based on start date and duration (working days)

The parameter is:
- duration (int, meaning the length of the task in days)
- start_date (date, meaning the task start date)

These parameters is user inputted and used as where clauses

For example, if I start the task in 2023-12-01, and the duration is 5 working days

And I have these holidays data:
- 2023-12-03

Now give me the total off days in that range

That means the off days is 1 day, and the end date of the task should be 2023-12-06 (2023-12-05 if there's no holidays in that date range)

But, the thing is, if 2023-12-06 is holiday too, like this:
- 2023-12-03
- 2023-12-06
- 2023-12-07

-it should be shifted again, so the result is the end date of the task should be 2023-12-07
Or, if 2023-12-07 is holiday too, then the end date of the task should be 2023-12-08

Give me MySQL query to get end date of task where 2023-12-03, 2023-12-06 and 2023-12-07 is holidays/off days, so the end date should be 2023-12-08

Here's my case:

> duration: 5 working days

> illustration:
1 <- 1 (start date)
2 <- 2
3 off
4 <- 3
5 <- 4
6 off
7 off
8 <- 5 (end date)