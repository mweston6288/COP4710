table admin {
    username -- primary key?
    password

}

table professor{
    email -- likely primary key
    name
    username -- can be blank, blank triggers account creation
    password
    profId -- track requestNum
}

table request{ -- make one entry for each specific book request?
    profId -- primary key?
    bookTitle
    author
    edition
    publisher
    ISBN -- primary key?
    semester
}