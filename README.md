### Introduction

Canonization of email is important as the email providers give their users a lot of different
features to make their emails unrecognizable.

I noticed a lot of different libraries that tackles this problem, but I was not satisfied
with implementation, so I decided to create my own version of "fixing the problem".

**Note:** Canonize version should be used only to check if user already exists in the system.

### Email

Every email has 2 parts:

    example@gmail.com
    -------             Name
           -            @ divider
            ---------   domain

### Current implementation
Implemented features:

| Name                | Description                                                     |
|---------------------|-----------------------------------------------------------------|
| LowercaseName       | Lower cases the first part of email (everything before @ sign)  |
| NormalizeHost       | Replaces a given host name with provided one                    |
| RemoveCharacter     | Removes a provided character or multiple characters             |
| ReplaceCharacter    | Replaces a character with some other character                  |
| SubDomainAddressing | It will remove subdomain in domain part of email (after @ sign) |
| TagAddressing       | Removes tag sign and everything beyond until @ sign             |

Supported providers:

| Feature<br>-----------<br>Provider |   Lowercase name   |           Normalize host           |    Remove characters     |     Replace characters      |   Subdomain addressing   |      Tag addressing      |
|------------------------------------|:------------------:|:----------------------------------:|:------------------------:|:---------------------------:|:------------------------:|:------------------------:|
| Apple                              | :heavy_check_mark: |  :heavy_check_mark: (icloud.com)   |  :heavy_check_mark: (+)  |  :heavy_multiplication_x:   | :heavy_multiplication_x: | :heavy_multiplication_x: |
| Fastmail                           | :heavy_check_mark: |      :heavy_multiplication_x:      | :heavy_multiplication_x: |  :heavy_multiplication_x:   |    :heavy_check_mark:    |  :heavy_check_mark: (+)  |
| Google                             | :heavy_check_mark: |   :heavy_check_mark: (gmail.com)   |  :heavy_check_mark: (.)  |  :heavy_multiplication_x:   | :heavy_multiplication_x: |  :heavy_check_mark: (+)  |
| Google for work                    | :heavy_check_mark: |      :heavy_multiplication_x:      |  :heavy_check_mark: (.)  |  :heavy_multiplication_x:   | :heavy_multiplication_x: |  :heavy_check_mark: (+)  |
| Hey                                | :heavy_check_mark: |      :heavy_multiplication_x:      | :heavy_multiplication_x: |  :heavy_multiplication_x:   | :heavy_multiplication_x: |  :heavy_check_mark: (+)  |
| Microsoft                          | :heavy_check_mark: |      :heavy_multiplication_x:      | :heavy_multiplication_x: |  :heavy_multiplication_x:   | :heavy_multiplication_x: |  :heavy_check_mark: (+)  |
| ProtonMail                         | :heavy_check_mark: | :heavy_check_mark: (protonmail.ch) |  :heavy_check_mark: (+)  |  :heavy_multiplication_x:   | :heavy_multiplication_x: | :heavy_multiplication_x: |
| Rackspace                          | :heavy_check_mark: |      :heavy_multiplication_x:      |  :heavy_check_mark: (+)  |  :heavy_multiplication_x:   | :heavy_multiplication_x: | :heavy_multiplication_x: |
| Rambler                            | :heavy_check_mark: |      :heavy_multiplication_x:      |  :heavy_check_mark: (+)  |  :heavy_multiplication_x:   | :heavy_multiplication_x: | :heavy_multiplication_x: |
| Yahoo                              | :heavy_check_mark: |      :heavy_multiplication_x:      |  :heavy_check_mark: (.)  |  :heavy_multiplication_x:   | :heavy_multiplication_x: |  :heavy_check_mark: (-)  |
| Yandex                             | :heavy_check_mark: |   :heavy_check_mark: (yandex.ru)   | :heavy_multiplication_x: | :heavy_check_mark: (- => .) | :heavy_multiplication_x: |  :heavy_check_mark: (+)  |
| Zoho                               | :heavy_check_mark: |      :heavy_multiplication_x:      |  :heavy_check_mark: (+)  |  :heavy_multiplication_x:   | :heavy_multiplication_x: | :heavy_multiplication_x: |

### Features

All features are developed as PHP attributes. In that way we can easily apply/remove them from
providers without changing any logic in the code. You can easily develop your own feature in
few steps:

1. give it appropriate name (same logic as we did with existing features)
2. your feature class should implement Robier\EmailNormalization\Feature\Contract interface
3. add #[Attribute(Attribute::TARGET_CLASS | Attribute::TARGET_METHOD)] tag to the class
4. implement handle method in your feature - checkout already existing implementations

Features can be applied on whole provider or on special provider method. Best example is
to check `Robier\EmailNormalization\Provider\Google` class.

### Provider types

Currently, we have 2 types of providers `DomainProvider` and `MailExcangeRecordProvider`. Domain
provider has fixed domains that emails should have like **gmail.com**. Mail exchange record
provider has a list of MX records that is used by specific provider.

### Contribution

Feel free to add providers that are missing or to update existing ones if you see they are not
working correctly. 

### Docker

This library comes with its own docker setup. You can easily use it for local development like this:

```bash
# before first use you need to build the container
docker/build # to build docker container
# other commands
docker/run # to enter docker container
docker/run composer run test # to run tests from outside
```

### Benchmark

This library takes ~56.90 sec to canonicalize `1 000 000` fake emails (without MX lookup). I used `AMD Ryzen™ 7 PRO 4750U with Radeon™ Graphics × 16`
processor for benchmarking.

You can easily do your own benchmarking by running 2 scripts inside the repo. 1st one is for generating file with fake emails, and the
2nd one is for running the benchmark on that file.

```bash
docker/run php tests/Benchmark/generate.php [number of emails = 1000000]
docker/run php tests/Benchmark/benchmark.php
```
