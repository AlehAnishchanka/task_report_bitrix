This is my old project.\
I made it 2 years ago.\
May be code is not clean here, but I solved an interesting task here.\
Input data 2 tables.\
-------------- first --------------------------------\
ID      NAME\
1       First department\
2       Second department\
.....\
N      N-department\
-------------------------------------------------------\
----------- second ------------------------------
ID_DEP               ID_MASTER
1                            NULL
2                            1
3                            1
4                            1
5                            2
6                            2
7                            3
.....                        .....
N                            M_ID_DEP
----------------------------------------------------------
The second table is the table of departmrnts subordination.
The task was to create select for html with grouping by subordination.

The task was solved in common form.
The was bilded tree with container in the NODes. The container
could be any type of data. I can transmit function for operation whith
container.
