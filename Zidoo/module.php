<?php
declare(strict_types=1);

require_once __DIR__ . '/../libs/ProfileHelper.php';
require_once __DIR__ . '/../libs/ConstHelper.php';

class Zidoo extends IPSModule
{
    use ProfileHelper;

    // helper properties
    private $position = 0;

    private const PICTURE_LOGO_ZIDOO = 'iVBORw0KGgoAAAANSUhEUgAAAYwAAAB9CAYAAACxgFRCAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAFG9SURBVHhe7Z1Jk1xXdt9vVWbWjMI8AySaaDbZTXU3Wy21BsuSZVvhhdZeeOeNF/bCEY5weKtWhHf2F/CXcDi8sJYOWe6QwrbCDqnFoUkQJDiAAAiggCrUPPj8znv/rFMPL7Mys7KqssD7Lxy86Q7nnHvvOXd6L8d2DCkjIyMjI2MfjJfHjIyMjIyMrsgOIyMjIyOjJ2SHkZGRkZHRE7LDyMjIyMjoCdlhZGRkZGT0hOwwMjIyMjJ6QnYYGRkZGRk94ZVyGMf1Skl+lSUjI+PbgBP74t6O/Y3Znx1MiuKe8LJIhC6OBex6T5BqeMFyaKfNiedYnu9ibDeQ5x2vMzIyMl4VvJIOg3s7aTtt70CbRltmyLfS1s5GeV3eK/8K7+FnDrmF8bFxM/4NO0Kt1BhrpsZ4y8/H7Y9nVeeQHUZGRsarihPnMMTuS0aZ29yyI6Z/a3s9bWyvpvWtZaMXfr62+Tytbj1P65sv0ub2WnAg25budpkIaeMOxs05TKRWYyo1x6fSZGM+TbXm03TzdJpqzqfW+LTfHx9vvuSvHPAxVqZXHyIjIyPjROGVcBjtUYL/Y2yxlTbMSayag3ix8SS9WH+cVjafpcX1++n52n27fmLOY9Gcxqo7EhwHIxBPA/NuIwdGEq3GdJrCUZiDmJ+8kuanrqfTk9fs/HKaaZ4zB3Lawk36SIS89zgxeMkOIyMj4xXCSDuMOudQxdb2RlrbWnLnsGzOYXnjqY0oluy4kFbsfGVzwZ49s3srfoQIv7lVOIpilMGUFSOMAowwcBrNMRth2CjCHYeNLGZaZ32EMW3Hmda5dGricpqduJDmJi4ZXfDn42PNMpVduBwmQnYcGRkZJxkj5zBgp85BiE3GDxj3rZ11dwJMMy2uPUzP179OT1c+Swurnxejio3H7kSYjtreXveRRxGXdOzIX1t0rvxgeXOym7/zslOMOoo1jbHUMEcy2TidTk9dTWembqQLM991Oj/9ujmOixamaWEblkqxCU3ydJItIyMj4yTgxDgMsLWzmVbWn6ZFcw7P1x6kpY2HadmuX2x84yOLZXMSjChYo1gzR1GsU6z7CGIvakTWrY72vBgfEIz1jeY4o455G22csZHGpTQ/VUxVnZ9+I52b/o6PPiYbc2l8vOGxQXYYGRkZJxnH6jC6GVBGERh6aGtnzUYKyzaaeJGerX6ZHq98kp7YaOLZ2pfFlNPGs7S+vewOYpsppu1Ndy67I4oo4qAGu0iDsQiuw8YZvs7RGGOtY8adB3Rx9rvp2tyPbMTxpjmRq2mqccqntBhxePxS3dlxZGRknDSMrMPY3FrztQaI0cOL9W988frZ2hdpwZwGzmJp/ZGvV2xsr6QtcxI4iAJ7RToMEXf5HnNnwOI3ax5npq6nS7NvpUtzb/s0FSMNRiCT5jiIkx1GRkbGScWROwzvoe+UxrJtM4v1hGJ765Y5gDVfnF5af5AWjRZWzUmsfOHrFDgJdjitbS36GgZTTsQpVyG87x8SdgzbOO+qbFd1vlCextNEYzbNTpxL52dum+N426eoLtpo4+zUDXs29xIvpJWdR0ZGxknAkToMN472F7ebco+RwZY5CRwA218ZSSxtPDJHcc+noBZW7qWFckTBiGPXvHIWro7J8EYVFqOcHd85dcGcxnkbZVyb+2G6bM7j7NRN34rr4co48BzPMzIyMkYVR+4wQNUwsk6xsrHgC9lfL/2d0/P1r9Li2tfuQNjpxPrEJrudLOwu9qYzCg4DZwF4G3yyOefbbi/NfC9dmXsn3T7799Plue/7c0KJ2+wwMjIyTgIO0WEwzdTZCGL8i4XsRZ9+Yk3iiY0k7i/+Mj188X65LfaZhyON3W2qZXp2KKafRg+oVDuzmo1Jf+nv/PTt9Oa5f5jeOPP3fGcVU1cuk8mWHUZGRsZJwLE4DNYqltef+DsTT1Y/SU9X76Vvlj/xxWymozZ4sW5n3V/KY4qnlsURdxgA2Xl/A+cw3Tzjo4yb8z9N10/9OF2YecPvs/axd/0lIyMjYzQxVIcRDWUVTCnxfsTq1mJaXHvgn+jAUSysfmbnX9sI4yv/ZAfh3Nm4ES3SI92T1vsWz0hQfLRw0ndLsQB+Y/7Xjd5Npydv+NvhbM9VHHDSZD0pOCz9tst6BOvpYfOU6+y3CwM7jG4VpXhWPOd9iK3tVf9Ux3NzCrw/wXsUz8xhsAOKkQZbY1nM3thatVjb1s/e+zMdJ7UyRh0xkmiOTabZ1nnfcstI49qpH/pU1ezEeQ8nEC83wMODyoWjzvtFUaZFGXEcxTITT1FGnQ8id5RZGDWZMw4Xh+IwmHLa3F7xD/uxmM03nXAQT1fuGX2antiogrey+XQHYfSCXvyeU8RJrZRt1dLQijP/yu2pycvp6tyP0s3TOI0fmdO45fdxKoB4uSEeHra2ttL6+nra2NhIm5ubaXu7mPbsVeeEa7VaaXJyMjWbNnpsNEayzMQTRwhZ19bWCrlNB9zrCRZufNw6PCbn1PR0mpiY8GuQ6+m3CweektqNvjuNtLa55IvW0DPeoVj90p3FwtoX6cXao7S8+cRGEyu+TkF8Kp1GFa9iBZSOitHTmE9P8X7G9fl302unf9Ocx6/5Z0VY0xAUJzfI4QNn8ezZs7S0tJSWV6wemgHFaYyj6y76btdVo/n5+XTmzJk0MzPjBlTPRhHwhpN88eJFev78eVpcXEwrJvfWPo6SGsgTCAcxbbJeungxnT592p2kdJHx7cEQHIZVOn+PQj9QtJ6W1r/xBW1euPtm+aP02EYVT1f4KOA3Hl4f/yvi783+VayAVRn5/Ppc60K6OPO9dMNGGUxPXZr9XpqfuFw0UtOB4uQGOXxgLB88eJC++cbqqTmOdet1Y1DdANrzvaW1F4TBWF66dCldvXo1nT17Nk1NTXl5jWpZ4QwZXTx58iQ9fPgwPTa5n5nj2LB7+zV/JEKupo2ocJK333gjXbl82a9xIrl+frvQl8Po1ChYe+B9Cd/1tHLX6FM/Z4TBy3YrG8VnxZl+YiThvx/hVbGojIePQsRdSXUitwU4K3kqj7oGw+ITHTL91rRRBjunLs6+5Q7j1pnfSpfn3m5vtxU66TxjcDCy+Oyzz9JX9++nx48fp1VGGWY8xzCA9ny3TrwMnmMob968md4w43nRetxzc3MjXU44DKahcBZffPGFO8snT5/6PZ7txzfPmXrDOb7zzjvpNZOdKTmNMjK+PejoMLo1gGJUYX925KU6RhTscrq/+Dfpi8X/a6OKj/2T43w0kDD+U6bmKI6yctWLxRC6POXcm39xvov22KekmrQqYuymsz9InfDohbUevjV1efYH6Y1zv+dO49z0LXMaM2XoAt3KIqN/MC1z586d9Pnnn6eHj6xDI4fRo45xGLdu3Upvv/VWunLlive8VUaqK6NUXjgFpuFwFPfu3SscpY02NuxefTvZC2TBYZw7dy79+Mc/Trdef90dBvck5yjKnTF87N2O1CPoIbM19v7S36aPnv739MtH/zX97YP/kj5+8ue+A4rFbCZeCieBsziuSoR5xrlt2v/WmzLCUI+nZmqNzaSJsdNpevximh2/kubGr6YZO06NX7D7p1IjTVj8MZM1xLV0SG84MK1Y4+LlRT578tnC/0pfPv8b33oMaIA9tOWMAcF6BYafo4wcx26kMPSsIY9vpPujDsnhspfX8X43Qk6Xu5QZ4n7Gtwtth4Fpjb0NVQbu8blwpp1wBLw/8fDFh+lLG0ncXfjLdOfJ/0ifPP2L9Omzv0xfv3jPHQlfj/WedPlBPkvtUCtXYVwjFUadX79rjU2nyfEz5hgupLnGtTTffC2dbr6Rzja/l8633k4Xmj9IF1rvlMT5D9K51lvpTPO76XTjVjrVuJFmG1c9Puk0Lb2xHZNrx2Qq/5C1VxBeQDeMwl6sP0oPXnyQvlr82/Rk+V5aXl9wR0WpeDjTHXJlDAfo06ef4rGsnzqvUvtZaSwBi8aMTFj/gDS9A41qeYk/qHodSdhz366Rk6ksRizIjszIqjC5nr7aaPzcUJ47KPQIjC8/RsTOJtYn/FtP5hi+XnrPp55Y2F7a+Ma/HssHBAsj93KlqaZ7eMB8s+Ol6cZ9yoz8bMNGEM1r5gBedydwuvEdcxy30nzjZjrVvG6O5GqabV6xkcZlC3vZRhqX7PqSHS/6iGN6/Lw5i/nUSkwV7fgXch3lRxRB0ZwGgOsFjrdTa9xGPeNzabIxmyZbc9abY8jf9ulHqMNXGxi7pwsL6fniou8cinP5++mYpziMU6dOpXkjbTHFkHKkFy6MSnlhxOFPu6RYw/FdUnYPdOOTZxqNsY2YHVIs8qOv9nN7FtMYFbkzho/aNQymnLa2133rKy/UsXC9aCOLb1Y+SY/NaSytPfQdTzgSplTaP1xk8YoRxS4Oq/Lssm3HMg+mmhpm1pkGa43NmbE/60Z/pnHJHcfU+Lk0MTZvjmQmNcYmLWxhkAtjD+FszHjzsmGyHpSNlNZ3zKDsLKXVrcdpeetRerZ1Ny1ufeFOw/qXRRxzHP06jKj2goeGv/l9deaH6Y2zv5deO/tTf6FvsjljYQs9Kk5ukAcDjuLu3bvFGsbDh2l5edmdBoavG9C/nMLVK1d84Zt5fZwH92dnZ9P09HQZenSgNQxkReb75WL/WrmGUVefYl3jKesVrNWw0H+ZXVJ2jawQDoTrTmllvDpo/Mmf/MmeEQZbY7WQzeiBLbEPXryfHtiI4v4SHwb8VXq6+rk7kdWt5+4sdqeAdof3oqHC6rCmf9p58GcOgl++mzAnMW1OYaZx0UYQN9Pp5nfSmdYb6Ywd5xs30qnGdR9JzNioAWcy1Zi3Hj00F4hr6zmOGXEcn/VpLYAjWdtZSOvbC+Yk+A2Ocj3DxISPfhD1w/+ktbO96Q6YnVKzzQs24pj03VRVvWYcDBjKBUYY1tvGWdDTlrHbjwDOYcYMJe9gYCi5xigz2qAXPmpAtkFHGI5S9pbJd2rORsB2ZDoOuZEf0shq37QyTjTGiwkc3qFY9/n0tfY6xa/S58//Ot1d+J/pztM/T3cWfuHz7IwsNrf5hEfRq+bvSEF2niU5W2O1EUUzTdr/cz6VxPrExdYP05XWb6QrE79h5z9KZ5tvptnGNTP+py3slMWjRw9wPgXpj8V6c5t2tvuuSAHulIveFjk+OSiKfHbMEb1Iz9a/tJHc3fR4+dP0bPWB/yytensZw4GqEAu4GLpo9CJhEOsIo0iZMIcf5/PleEYZzrsdB+USx4izQFbOoVw/vz0Y29ha22HaqXhXgk94fOU/WsQ3n4qRxANfyOY9CyqGz6u3m1xRAQ8beytkYdibY1M+AmilWR8tTBqxFsEoYrpxvlykPu2jAxxL2wHYaKhIbbdHiSzFOXe30sbOclqz0dPq9tO0svXERlIL6cXW10aP0tL2l2ll+5GPxHZ8YdriDDAlFeHykbfxtrWzlS5MvZlunvqZf6AQOj/7emo22LU1PJDnUZTdcUF1pk5GRhX3v/oqPeTFPRtp6HMZ0QiCvfVuF6R5en7ep6MYZUBsM+U9Bd7+Vp6jomP4QD5NSX1psvPSIo6uE49Rdp7jQHnf5OaNG+n8+fPta6apmIpjZDUq8h4EkrtXOV4FmUGvcoytbi7uPFu1CrR8Jz1a/jA9WPrAP+HBRwHZ7eTbSp3qe09HoazdfDH5RY8GJ+EL1kYsYvt00/gVdxJMUVnf0WxweP/Dkih68rvgPtM9Rc/Rwo5bD2psPS1vPUwLG+Yw1++khfW7aWnzoTmNp2nTRmDbyRqZjzTsT3xZ8sNwGAV7O2miMZ/OTt5Kr8//LN0+9/vpxpl3fS1jmCDPV6Gid4LKpk5GDKWmZvg0CMZ0dXV1j+PYD8zbz5qjwFAyFSWHwaKw8hwlHSPXo0eP3GHw8h4Oo5c1DMDztsO4eTNdCA6D9ZvsME62zKBXOcbee/jfdh7baIIdUKxZ8ENGyxt864lpJxaxSaRI6KgUo0Lz6R+3ohj2VjGqGDuVJsfOFKMJcxYzjcv+DoV2MrGYXTgGDHqRioBjaJhjaDSYfmDu2eQZZ3/SelrfXjRHwU/DPkjP1j9Pi5t8TfdLcxYP0to2H0lcthSKtNCJn5XqOIiziGhXVnNyM63z6drsu+n22d9Pr53+WTozcy1NNKf8+bAqKenQm2Y6Zd0MCi9ycW6JD0mi4QKZReNmsDBaEB/F03knRJ0hI3P40UlwvmLEZ0J4vltrXgapMJ8/ZUaSqSycRZ3DqAIeyAvSFNZRTOnsUMaWF2938/IeIw1GVvDRqS5FnnguB9GPw2jXLatX5LWFzBq9+f9HDMlkPLLzS3UGhw9RlnWo05H089J9k4+2hDNul7ER4aNOjwyBP7d/Jm/L5JS8UF35gzq5x/7ze/9m5+nqZ2YcH/raxKY5is3yh4ssShGqRKeED4I6Je7mg+HCfFovbrzY9cR7EafYDmsjCha3W+ZAeAmPRW92ScVtqILSKxq3KcnfUrVw5iw207I5hAVzlF+kx6t3fKvw07XPE59c95+G3THHaSOs9pRWUMGwzap0QV7Ie37quz419dr8b6Zrp99Jp2cu+3OhrkD7AfFpyL4Yurjove6V5eUizUMo64FQ6gSeIBwFFV9GmgVY7+Ubcc49GkVVL/EamZmWwmngMDBoOAxI6xFd5TeeyJNRhviA6kYYkKa5MCLkC/E5krbjwIiWcnbNd0BgxMh/ycqZjy7WLfZXwX2B53IQ+zkMwBG50C069pGc5efO2e7zPKZ/HHBHYWVGGTKliCzIgSEFUSecw6+OugckCyTnuGjyQnQ+kFmOwwJ5nCNHyavLbPKxs23OZOWI7JQdbaqKqANh7D/9nz/e4Xcp2J3DHLo7ChSAcaygLoGDQgVQgFyLN8Sb49YYx+Z85xPrE6xJMIrwN7LNUUw1zvsaBm9ku6Nw473LH7xqqqnZLIxMo0nFH0tb42YYdhZ95MBW2Rcbj/w3xBldsX7DN7D4iCK/5fGSPoIKhu4wyMP/bZkDnEhzzSvp8swP041TP01vnPuddPX0W3vyR3cHKRM3YmYkn1hvkykKiC+ZkiYvqCH3qMClbJdpuTvHGgCG2nuIpQGnEbCTh8ZPGDWEqCccA5/GeGZyY8xo1G7MMOAYUagMWwtLi+kojCX5TeI4LK89aximOxzBqqUrJ7FkusVoR8cURxmS0WlIuidNUvKyNl7kJJG1nW/QjRDbJc97dRjIRB5xRxbn3KPnzSiDlGP6Rw3kYYRBx9ENKNOLJgOysCaDXNxHRoWXnsS3dIYOvcNhOqXtPDeHjLOgvLmvTgHxjk1m4xVufVRu7YGyYpffrMlJBwe5kZkRc4RkjBj7j7/46U6xoG0e0BNWA/P//XzYaBvf8lDkxc6lgjCWvFU9O37JnMQlf/GOF+qmxs7ZKOOMv+DGS3lMUxVxlNRu5aewIfX+Go3xtD1ujTRZo9186LuRljb4pT+OD8vf52Dhf9Gn46wqeDptHbQP5cmQ8HIlKqSRDs5PvpmuzPwovXnhD9JrZ3/icjCIUgU+CKjsVGymKPi+EPvzmaog3YOmfViAL3ca8GhHyrgYObbceNPw+SDgxQvWwcCYl72nKA8G7Isvv/TpmYWnT4upKGvcMqD2X1Gf6hp4qRscA3nMWWOj8cFDHGFgKDAiGBCmgtArvXsZkugoRIepc9InP4wXR0j36/LlvsBzOYhODgMDS5oYTb6K+9Rk5qgtvDgLpmZc5jLdmMdhoyqjZJKNcKdh8lCmfIkYx0HdoVwVt6orrnG+OAjKljUi3m+hfqmMVc4e3v+3vMvjUUA8e54cS7kZjTO6OGN1ls0btJmzVqernSyVkeQe+w+/+MnOmhnJatEVzw9HtD0Ow7JAHIy/ieHTS5Nj8+YoLqa5xvV0qnnNHQZvXLNGwRbaAqUApRJ07sbESEYEajINZYZ2dedJWli/lx6v3PGXEH1HmDmMFV+zWS4W9p0pI/9X8glKVZSqHxqqjUa6cD3YyOpM6zvp0tTb6dbZ3003z/zIetLW82E6jbCl3IOCikzl/vrrr92AshhKI486HWU4h6HMNb3AZ8evG2G8MegYsygP02+ffPJJ+tJkppFj0DDwvcpMXjSwa9eupTOWh0YzOBGMKGWKYyAf0ocwoPS4MTA+PXEMqNY1IINSRQzL824OA50jP84IWdmF9cQMJzK/MD1oNDOqoDypIzgIfu/j+vXrXr7UnzjSiLri3B2kOQucBJ0u2hEyM4J0x1ij71EAfLnTMHlxjOx6o83w2XpNUQFklQySu/HH/+L2z/3lu7JHzYPiYW+Npx/scRRuGq2w2KWUbGg4bhXPRhNnmm+k860f+Leezra+6y/gMcqYtOcsevPJD2Ow5JN0Cp4pdJwDwspwcJyamk4TrUYab46l5xtfpS8W/9o/mvho+SNft1je+MbXKnybrOsgFHI7H3gt/oaFWBAiPmuOfJNjZoQaV/3TJWeat/37V7ONSz6yajSLHjXhQbVA+wFx6fnRC8SY0UvCgXD/qAiocfVL20bqwXHEYGGQeWYK8SG41jaifgjjvX6TV1NSxAXVPKoESGvejMl565n5kN4Mp+odDRGdkjYG5Cu275oxoeeNIVEPvy7tw6Y69FJvCCOjiry0rWhkqY/on7qDE/7s3j03nEy/qaddx8+okOoPvDIlyUiIcqTueIfT5CNc1BVxKM+n1sFipEo54yypS3G6bxQJ3iDqIuT8msyAOhwdhkho/NN/9Zs/54Wx4rcq9j4cBmCwChammXLhEx18qoO3s+caN/yNbD7+d37iHTu/5aMLetktcxRazC7eKucTDbs9SwqXQpWjYCpC0xETEzZyoUc+Zr2B9fv+Haynq/d83YL3T/SmOrLvfaPaotjfsFHVB06i0IU5trFTvk6Dgzjb/G5Jt32k1Uxzzk/L5JHDiDQI4IXKQkPHcMqoSa/VPIZJ1TyA7utePwRoBLE3i0Gj9y8DJ2AY3FmYvIwEaDTognQ65Q848hz9M/3E9IWPYsxhkBfGhXTodfo0H9Ne5jTISw5JacS0q6Rww6Y6dLofQRh4rnMYEOfUm2+sp32P9zxMbq4xwjG++BDp2VFQN50L7U6H1Y/x0p6oXBVW9YQ6RAcLZ8FULp/Jpw0pnGgU5eYeQBY5StoN12ovMbzCetwz0zfTZGPO37XQKOMwQNrGnv2tc2G96FPptDkF3sa+OfWH6dbUH6XXpv5BujDxa2VvGgPJUNC8In8WB6YjaVhFg6Uiq/FS0DTqtrJsDNMcn/Dfmnj7/D9Jb53/o3R9/ifp7PRrqdWYMc6sV+Ev4hXpHj4sH8sTSjuMr06lufHr6VLr3fT65D9Ktyb/cbo2+Tumix/4SKORps0ImnHfLN4qpnDVaxsmSE+9j8PSRUy3WikPCqUVGwE9p2GlH0Ga2tqresaRvPlFu69ZDzKDgvFR+FcNkonFfabfcBSMLGL5HgSqK73QMMC6GHWfTgRrW0w18ZFKpiyreeAQ2TjxwDoG/tsiVtdkiAdBVZ5+aRBQPsSlzjIapOyos3Qg5UCqaPzLf/vPfk5ve3n9sV3uFnDfhU3aZZTdjIqb/NGLbo3P+jsUbI1lBHG2+VY613rbe9KMLni3Akfii9nliKJIY7f3hyOA8PyMIuKoQsPjtqMoZSjOzTCbc5iduJAmmrPWo7devTkRd2Q75jDcWXZ2mP3qo74QC30Un10v1ij45Dpf0GUkcb71fRthfT/Nt173Dyb6ms0Yw8NCF9IBFA3VoIBH9crVA2a3z4z1MnyUZrpl5wS7gNDzMIlpIsoK/sUH6FcehY/x6BHCP1NFzNFyTl4CzsS/Vvv8ebtxkD9p9JI/uvcdNUbUOa5pdJQHabMWxCYCepxcC3Xp19eTAgoPxTo9CFXTE5E/x27gOfnXjTA44jAwrp9++qnrVGUp1KUf5RYvpDUsUppVdLvHJgr4UllSruzEo4zjKJXnbGK4b6NHHAYjDdUfoLxjXtVy1vPI80FJ+cV8QfW6CnjzMrNwap+ULW0GHQDSIFzjX/+7f/7zxfVH6YU5DHra3uvFxO+TSS32RDHPZ3+WkjsA3sDGIZxrvem/PXGu+b0038QwXvZ3DjCMFtLTqFMuCtEaBQZATkLCdTOgpFfct3Tt0Bhr+K/aMbLiRT+mhXgHhbWMguuC74iB9NEG8hTpWjX0tQgW8lmfOG8OE0dRTMFdNV3w8iF7wYvKSRwBHiBkRReS+aAgDQw4ozN2TbBbAmPINUNU9my78bV7GMpBiMVnjnxSgyPlRg+dsqEBQmBQPSse2pqyeqHtkdSTqCvCHcRh8Jx0cKbUP9JFBtIApM3aBb3O6gL3fmlHiBfSd96hMu9BSWlWsR9fPCd+1WG4E7ZnyE7vFLnpjVfRa/qUk4wUxHk/pHiKS7qUTbQn+/EiKB14og1QZ7kmLUYXOAycJLvgqjL3kgfyis9hEGmpjF3ePmUmjMtracnGqgMeMfbx47/Yufv0F+nThb9KT1bvptXNhaKH70/3z8gNWps3GUUTgM+HM6oYmy0XtNn1dM1GF8XvT/Brd4w4eI+CqafqL/MhgBSggoOotDpHGIWRUnREaZzrKDiHNqLgl+2erz5Kj5Y+Tg8XP/a1Dd525/0M1nS2EhsB9B5GGVn87Sa3i6CDNmxUU/yZwTJ9sGivz64XeoCulS8gslUYp2kV3Z3Frjwi5EV+zTNyjvxAjSLKuh+Ig6HUwhfGjSMNgkbAUfcPCvFFfqSpXUT0wrXVFPTDP5DcgLjoA4d38dIl38HElkE5PhoAOmOt5pO7d30kwFoD+cMT8TvlH/VLfWQXDbtK2BklA8oRXX7wwQe+8IsOOzmMKt+ANKIR4RzCUVggDzMQKGcjlTPEOTxAdTJX+YMP9Bh3STH6xJGRHjujPvzwQ5eZZyDqTIj3XF4j3pqnXCDitkOX8faTfJfTApILGalXLrMd/R2bilxV6Dn2BXnZQcRP0r5uxDX1l44Guwr5zApOkhFGTKuTvDpStnTQkBfZ0cMw3ntqt2WTdc+b5nYfdJOXZ/BDp/D6tWvp5muvpQtsGzeZedbm/+HSRztfPv9/6dNnf5U+M1pY/dwKsdy6WhEWRIUDS4r/CuxwYhn7y3ZnfFSBMeRz4jPjl32aZbpRvEth1c0diyVORI8ukB8VR42m6ii4B7miA2+gWkAC96tyvFh9np4u3Tf6Ij16cccd5outB05r28/SRsJx8L0dFB6G2XvZLdBOujjBCfL2OY6i+JwJPwd73uS/4O+T+A812TnTUhPmVHHSRdy9iSOjDIn0oGEj+qnTQa+QrjhKP1QwGj09b440OCreoHkIyoteN2nrzXKMddyl1Gs+Sg8ojhoijZzKjgGXo+CcXhMNACd1UIeB0eR3IRjJyGGQPnJ8+KtfuTHRwi/PqojpQYShfEkDUn33et6Bp15ATHJi2kjlKp1jSFTuVVT1Cx/RYaBrCJAWu4Q+vnPHzwkLuqWr+kx5eQeoLCemgNoo4+8n/S6nuyAfypQy4K165GaLb13nJ/Ip/igP2hgdjtfNeOIwOCcso0fqjuoPHRDu16Uj8AzniM5UD72ccbp2P8YdFP4JGKt/vP+jclanL6KOT+5RHnQCqNfIy/sojChlZzzc0tqjHT48eO/Z/07vf/Nn6cHS+/awZYVgCYXEhKoi7Kn9mVEbK0cV5gj8jezGFXcW6kFzjx1RGFH1okmXvzKZ4tqIygSTMpAibzylckVVRAVEcD/eo7Gsra+lpRfP0tLy0/R85ZF/1v35xhfp2eZnaXn7UVrZfuI/nsRn33nzu5iyo5HhPKQH0izkYJ2E6S1TvY8WGEEVv9FxIU2PmbduXvWpKBxp8bvhxSgM51LwBhV8Sk5klj4gr3SmF3TTNigDVri6So1eqGhVh6Hng4B8aKgQjYvhPDuJyIP0ud+p3DohhncyHUxbZach0rDZxaR6g940zGb08cLk4geUhukwuEceyPPRRx95D7RXh6G4MiQQDZfy1VRUUTP6B+kzumDxH52je03FSe91Mos/IB6rDoN71BfkZKfQ3U8/7dlh8FkOOXSMElM+Mp4WyMMI3WrEnpAxP0vDjafxRvkiN1upKR8hloGge/BBmTBK5b0Ml9s6IZQJU1GUr7ZMx91RQjVtjugMmZmW1dSejzAIA1Xk7hnK1+JTpshMh4yRj3Y+wk83ecUfDvyCjZ5vmMzUb0bQ6pwStvGnf/rvf47xZnspowvWMojsUzFlcSgDT9xlQzk8MMWagdSnxplqOtu67esT51rfS6db/BTqa+48cBhMT+FY2vFJghP7RyVTw1YPmgbEkXt1DkOAL11Xnwl776E8srW0zFhj3JvGG9NFPoVWfo6Eo/X5XD7CFeGVB3xg6GnQxUiiNT7tzoCXDn1hv/GG6YAfcPqu/5gTazY4ULYRk7Y7C0+j4EpATjkEZIc4J98Va5D0mGgMkhudyChFXXSDwkUSqHSkzxEC1bA9k8XFYNFQ2YlBw4UwWBiXavr7oSofcnu9Mf2csoaIs8CIU29UXwBxuKZObZpziIYTZ4Hh64UHnpMmjR0DqrLhHukjDz1Q0uZ8v/IgHvFJy98UN96ZFlDdl9ODVCf6ITlMeGNKhnJA75IZ9CozacU1DIg0+D4UW5TZYYPM5NUtTXTCGhDlBJFm1GWV/NtvHWhPWJOzTeU9ye580jmxI/lH1PHKPeIh87TJy9v88AdwQHGEjE4J3ykdQFrExwDz/g4OEj1ioNu8S45+qSIzRL6UBe2YskZmyd2JT9Vh6h3yqv5xj2cehp1CU635NDthRm7CRgWtc+UooB679zEGloCFZdGa6RUWtK9N/la6MfU76fLET8xxvOkv49kgzJm1IjPjgYHYW2BiFOZQIsqENJ1AoYNqQQ+OonD5xtTU1KQNh62nM2M9u2nrmU7cShdbP05XJ3+Wrk38LF2aeDedbbyZ5savJX7itcVPvCZ2WRWfJ4FwMuxo4vns+HVzFLfTpaal0bI0Wr+drrR+6ovbfH6dH3Bi6q7Yyrs71QU/onZFtUJDHxC9Lyo7i4vs/eYlIXoQNH41/GEgVqpIMhC9kuKRGvzx+Q2MNIvN9HRpZIPyHesBedFA0BWGFqNLvUGHnn8ZlmM7nt0/DJBfP4Af4lC/2VjA6Id6X63zELrS+SAU4w8bLnefsjdp6yYzZYVhUlnB57AIqG7QhtyeWL69lpPCkRaGV87WOwJl+r2AdKintGk5Sco4yjws2Ukn2g50KwfSU9mXMiMjjgZCdtIGjZ8baNW8h7C1bT2Q7eW0svm0+FSGGbUiulU0u2IRGNCbLqadbiTeyOZlO7aDYhTnG68VowkWtK0HzQjEuPB4nk7JNA0aQRAI4ShMCYjA6hkgaCTic4yoXneC8o7pQRQmnztvNqxH0phMDXOijDr4Sm7LnAPrMdONi/4zr/7Tr63XzSl8x3/dz1+ua0FvuoPEaRY/CXvTnOjlNNWwkYrpAse6VxcyGBi9YnSF7PS00IMKmeEkjoGhL1s19fmBZesZEx9dqVLU6aYT9gvHc3gifSo3efRClCVHZCANFt8YssMznx1Rj15lAXrlWSAuw3h6VeRDrxxHoQVo1RvAMTpgerbkfxgjDPSFU0fObiOMeE9tAN4hriP/gq6VP8deiLCAPCkLphmpU9FhE64blA46rI4wSBeDQhmjU2RWnhGEE3jOrrvTJq86heJX4XStfNAJx3ivGxE+xrGEPW3kZpQe+fHnFXDP67/xhjOHT+obOiMNRhZxwwbhO6UDD+gOvdEpIC3xBR8xXuRf5/0SfAM5OYhRNXVzPz7Jl/rIxzVpL/AtXZLumDG8s7ltStxY8F/W+2ThF+mDb/4sPV65a05jhb44qRVHM6E2+PeeNAaR6aZimuW6L2Sz08fEt7+ykGDE4+0FmdMwZIg4wpgEBlGo/Qq3X8RCUtocVRlWVpb9h3XW1vhomjUsfkDKnKm7TXOsPlIyZ2qRXL5iWqpZOAVfnyFt04ETz7mu51sFAcngAnoyVEYZWt/CZ0aIz07AK+GvXLniC3LMsVIRmcev6q1ffRFHhD503ivIj3gQowmNhiD4xzgLvfIW8ycO18yBoyt6a8wz86kOrpWmwqmu0Ugx8DQEphOYbz+MNQyMsq9hWNrqjapOC6SlfFirYMvxVStLdl6Jh8gH56ShY2wjUTd1IAxl4U7SOh58kZj6xNw2BiXyEhHT5Tnyob/qGgby4YBYw/j0s89cZp5VEfXHwvb5Cxe8/qI/dBAhGUk/ytsLojwcuUZ+yhiZWXug0yVnrnCC7pEn5cmIj8Xfy0bUIcJiI/TbInu+8FyTDveQg7pJh4CddTjdGF7nhBPp/iCAd3U09RXqZ9b2WAz39bCQbuSTcsMO0/lCXo7I7w7EZEeGYoThEUxBzVn/RAi/wLe2yWIvjdsSStZ7NCdxpnHLRhE/8JEEaxTzzVu+PkEPnCmaYiqr+BOkDDFDIZAxjQzinPs8R1CFj4jX1WeDQunoqErJNYa36T+yROHZ0dddcATW8zPSmgVrGw0jRiPFgr85PXcYhCschqXo6QJP24h0kRnZRRQKhUePF+dApeZzA98Y0dCZI2Zah4quyq7eKTqFuJY8QvW6F4hPdNIPobeGlaN/S8kaFMb4kRFOj/ULjJYqKOiXN8XFwFCRaXg+/11WajU0gfSpV+hGdY0wNPiDvodBerUjDCub/UYYQPeYhycNTcHqPkfVE3UkYl1Rueu8ExGGNOARB8H6FxSnMuv4i+A58pFO1xGG1VNk5n4n8IyNG3wZFv1pcb/9zGSGb5WX5EWOXqgurMqH2oNxp2wkO6iTn3uqO3Qy4JV0kBcZ0WEvIwzJ5O3deFOdkU55Rj5RZs77kblKxCVdrR1qVNmtUxT5gQf9XgZ8cw/ZOfeStaCpNW4Mt86mc9Ovp8uz308XZ8wpTN5OZ1q3fMGWhexLrR+naxO/la5M/Lo5jXf80x5M1fhidrJC3zFm+CNzc0BSBhkhBAzQKJi75BomCEvhUelEFAj3qsYF4l68PwhIBygdXaMwryQThYGZnbVKPUOvdC7NTM2kqYmZNNmaSRNNXvqzIWpjxvXGb3cU0284FqYTCtLPv0oPUroKlSP3AYVJZebN0c+td3rv3r30xeefp6+tF+NTUFbo6Aa9SF9UBHoR9HZYF0BvQDqSXL1CcSLBfy+EsyA+hgie4Js3YTWyqBooqBskAwTEC/qj0dFbowcUe/iCwnpZhoYkXY8kpJOyDJAHWWkzyIdDiUQ76oXQFcR5NAD91YwhA1k5+GnBicqLdoG8ke+DUNGOi3Pkl83pF7E+OhU3/VkvqMsRmeEHmeFvWDJD+lqD1/tSZrWlXiFZoy1udwVwGgCncWnu7XR97t10beYn6fLUu+nSxA/T+eb3fb6+mJvnc+N8FFAv3hEXJbLOUSbc2G2wMC5iTpAKSyh6otobjreWx8a4qNfXr5AHgfKSgXfjPmXGxmhq2rz+NIbeemytco1lnCEzzkEG1tuC3cNgGZkOSEuOQo0BPRCf/JAVg8qH23AW9Mr5FpHPsTOqMP3QS0AXqug6ch+dYaAJW+3BDwPd0hMfwH+a0viBb2RgZISjY+875SxnMSjICx3SGBhRQOiS+uUOy56LV85lcKOziPyOBIwfOHKujHf4RwL4pM6Id3UukAdSfeqVCA95nTW9SF+jAniRzDJyVb6HQqXsZabFsVeU4dvtgWOPaahcI5BXtkHlDA1DZk+Xc+Q1GkZZS+5xTlRgYKo5n67O/SDdOv276Y35P0zfmf2DdH36t9NFcxqsV0yyiMuWUE2/+PbS3Z5mVAIV3b9HZMQ98lDPmFfq+TQwPVAMTNtYmuHE0NDbjs4jDu+rCmgXYp+I6cS0IWRB+cihHg89uzkbdXDNZ9N5VlTswoFEUmNFdtdD6TCJQ9roAWPP/CIfbeM7PIwqmBf1+cZyCCm5RRE8x9kyBeLTPpZendOoXndCVR9Q1EmVFAZZKCumofhCK/P3j0wu+MGJaOQDiNcNdflKn+j/nI0qWK+hPNAl9U1pKjz3eCado3/ujRqca+M3lg6yUz9Ud+Cfc3QgWfshwJE0473jRlvmsqwls9oI8kaeB6WX0iizHUgLxuseVK97ADHEFzKqnqouD0Nm0L4uzwcF9TFiXImpoTbHJ9PpqWvpytw7Nsr4Sbo29+vp0tQ7/kM+rGMU7w6Yl7ZojCiIrk+Ny1GokUIMh0hXUxWan+elFwwLxBSMziGe6ZPBmm7BgFanXETIwPEgiHoQVKiqyMVQr1h7mS2PBRXTBoSBdK4jeiAN8pCRRw84B+nhSyN3FqYjl7XskftLPQbiigT04c7XHAwOg3l5DHeUQfrpF9W8qiBdCIdAnjgtyYIc/U5DKb0IwqN/9IeDwFHwngWOg7lvnsU0q41Quqde8mwUUSczhoP6ghxyFlHOOl3tB4XvN96hoZRB3FA+klnySuZB5BWqch9I+lAGjur1PvC8Sz6QDTmpm9UyPoi8QoxPqv1xuotY70DHVoQTaE4wWmDhlwUjTTdJKD845CxooCyKaYsjjZXeJ4aMb+u8/8EH6Ze//GX6u7/7u/TBhx+mjz/+2D/R8Nlnnzmxy4LPCxDuvffe82/y8MtoOBh6q3IYsTKBgyq3V5AnhYsjwIAhq+bSddS5iDl29MLQEBkwqMjN5yPumGwYWUYU7K7pVw7CoxOMNiMyRmscuae04HlY+iGdmBbOAOeGs2J0hDyMLHBikYd+oLJVXBoSWzD5JTQ++YGzoAxi+QvUQwyOT1tZHO+wVIztKEOy4zDgO/Y4X1VIZuSEvi0yI6fosGUdTusv0HYYKjiBQUSrZR5wommjhMJpFI+LHisvvaknhwGlkdJAKWwMmM/Lm/FgpICR5Ns6ENMvvgOIee5y+ikSPW8MHwumhFU8H3lYWvRkNdWBURHf4r1q1PpF1IGg9HiGfLFngA6QGx2IZKg0AkAuet3SA1v7uEZ+1h7i6Eloy6RjQPuZAd40vcWIDOdMetyTLqrx+0HUpfLlHiMlOSnKibLhnNETefc6sgAxD52jP3Tp22ZLR4zjQOdqZApLmVAe6N1HgRaPcuGe8o55jDKkLxnOOijMqwLJU+coKLdXTV4gmU6avB1HGDBMpZVh5KiGSsFyj8ZJg4bo0XEfI4IB4cuVH7z/fvqV9aTpfWLoMfKAdDAIdUQ+ykuGEOPKSIQ06cXiiJgGqRrZUQGfYMBwYkBxEIwoGC2xTgHvbMkDLEohc11D6Qfq6S+ak8ZRoxt0fVj6IV3ywLnTIcBZUO6q6AeRRaAjwgjNP/VRjiosYZeVRiUHQF7okPDUQeqkHMVJcRJ1OMm8Z/SOoyjnYbqelxxGbIgYMhojPTcaI9MBOAemYtQwMerqafoctjkLetL+4yJ2jzUIjBg9bcJibMgj5hNJ4Dnh3RBa+uql44yY3mLdg62bOCLCdOvRxvwGAel1S4O8MdA4N/W4+alKjYzQhV6eQQ/sGpIeIsR7lf/9QDroirRZA2EzgXr6Qjf+66DwkRd4Rtc4CmSE9AMysQyE/eR4iScLj2PQm9usWfh3lcoRG+lFvuhUMJKIIzt1NqroV6cZhwwrj17K5FUqt14kOQx5aWG9t/zuqB1hxEasRimHwZHGSQNmWgJjwRQTaxB8AZTRBIac7ZUYLRY+MVwYk7reYRXcUxiIOMQnHS0WY4S1qwgnhdOgx0u4GFdEmv0UhOJFKI2YLryhAwy1tpPCE+su6AKnhpN7Zs8IQ1gWs6MeoH75qwPp+DQRU4GmI5wsToy8QK951PHENengFNC1O0R0byML5JazqItbB4UDCks9YysgHRHWKtgN5Yvb5gR4GVCI4eOUKEecjUZrIuWTMVo4WG0/OL5NtWKYsnackhLUOHEQHGmAGG8Mku/0MSOJw6AX7XPoNhKIjmJYDZZ06OGqF02PXflypGfPfRlmGcphQ0aIPJCTPMmbH/vHeel7Tz6isGe8h8CCto8oyjSGCXgRITOOEyOunWUHLQPikgZpkS6y0SFAPuqAdkIdJI/YKWH0qilOrUNUp+yoizzDmeAoOoU7CYBf0bcB1BKvr8Xl0clOHsekZ3L0XI8hbzDMXF9yGCpAClXnIgwH0y4YC35hK34TnmkQDAgGm54tYaMhqaYFdUJdONIhPdLFSMEHDgvjBR9M/3hvvnQayn8QKF+v2IFID0eB8ZTDRH7yZpoMPtAFhhX+pIv29JNRlEs0KGJc8cj3Ypj6YhrQnVVp0AXnowsiT4RFXjkh9Mvo7qEdtViPnpVmL/IQVmE05SlnwXoFI4s6ZyHCuTCSiNNQcWQBooy6N4qAT/HavVReIahsQhkdCUpdS99jR5z/sZQv8vpheLnvO8IAZIjRoUctZ4GRZGqC3jW9WeblQWzghwHSJQ/48ZGOGUatG9D7xbBhqOvWCAYF6WAYMf6kjTFmJIVzYETB1BM6wYGgI8KCw9ZFhPIhb3jka7aQHFa/UJm7jsNoklEkzkJpDiob8TD+OAUtWLNuweiCezFdyYY+cTAaWWjNQs9PKtAz+h5WfR11SNZIhwnl4Xo2OuqaIqN92HJWwbekkHeY+XZ0GNUGiCGi946BVC8a4xh70FEpasTDaMzVtJQe+ZI/fPDhM94BwKBh4JwvlOUhOyPyXEXMh4/n4ZDu8J7I++/7exR88ZQpMfRCb1tTYd10cVhQfvCKkcepUUYc0YUAD+KringfORglaV2GNRl2ROGMooySqVfZFA/jzygCB6GfVOWDZ3yFFkdS5ZPwOAjWNVjnIC7OQ04ZKHyvvBw34Bdd8mt4TqVeq6i7d5KBnHEtb9ggzWq67FykXfiIuLzXNwbgVbzQLpU3dfYwUJUZ/ZKn52vPhtEu+hph6LdiNdUiJtRoIw0T5FMl5SviWtNFvgtJlREq4dfhCCK/ShtCXk3HMMXjhtNGVR99/LFvFWZhGwPKgjYVEYgnpRnTHiYin4LyUv6UD7xD8FcNq+tO99EjC9yacmO6jVEVeokyAh3rQHqRCItD8C/OMqo4U/wCGZ8o19bZmC6EY9A0FA6D0YWcRUQ3Po4Mpf56hRo1ZdQ2aJU0hiHXSOjGgGwusxlQfqmPNoYxHSZUbwD5oVPqs+/WtKPXRX/aHdVysETLkxLV5x2gMqZN+u9SmLzOg9EwyyWm5XXKZHV7aPnCwzDQk8OAERooc8zXrl/3RkujBy8p9ZBBfhJeP6DDVAa/TcDv0F67ds2NEL3ROqPSDapoVGKcBNNMeoeC3zhg2otKR2VXYYuOA6p0KgPk5bPRlBMvu9ET5x766rXSIMuKORnfVPCg+C0LZKaS87b6QQCfGH4fVdiIglEF71owWqgCPuJ6BXG0lVsOa+RQlkMvUJlRJtQ3pnXZgo6DlwEdlpykgy7ZbeajN9qEpTssDSJJv1aAn0v1Do11PpFfPA4b0i912Nc47dhLO1D5ePsqTvzaoWf+f3d4fCPKlA4B07nMgOAsvY4fktzuIC0f5GYtk/yHUZfav4fRCzA+CMgoQxVbigXDbsTVtKlU8BDnvSF9ooMFU859btvCxe8w1R0BeVCB1AuhAjOVw9ZUpqCYcsJo0ttGbiqf+CKdmGZMd1iIOoggLyqa9IHMGFQMKzqg9x6nbhQWHSo+aeso4FiQnalHGpgbMdOJwoJe5VQcSGVHeflnU+BR22aNN8KKAPeQC4dBWUNarwAx/H4kKC4yHtbvYZDOfr/pHa85h0PiuSGz8MhOesRV3YTHQUg9W2YH4ImpW21OkWPqVWbKgrqF7FxDgA4U05e0m2iYqnLqWjqBkN3rphHpc04aByW1Z2SFL9oyo+UXxqfrOSDyKSAbvFC+tCOmS7EpgLUBzbZgB9FvlA9Ur1UP+V+6i+0RwHOdLPsR8UQ4JTofvnPT2i91sSpznbzcE0/8njcyux21us09ygZd+C/ulXE6QhUX5qh0v7LeNu9dcB57rnWMHARiLQoD05MmyIwRRgRBEMwNi1VkXvKScBwh4lH4dfy5kk0GCp4fKWKtQoaEysaRikfjQ/46wOewZRfqioe8kEcGFVnRBdM8rgtkt2fSAc+oABhorgXxzRFiuEyvRC9fMgWFIaCMI3qVVelD4lXOXT+qT9koLCAsZS25OKp8Y+PqCvIsj/qFMfSl+JQrXw7wHV8Ph/iLe8Yn6TBlSdrUG+pMHd8xPUh1m/rrOip3i1GmqruK0w8Ujx4ta21sXoDQAXWfZ4SpIubFc3iAn/iLexDhkJMOBtO0GCzCKl4VSrctr9UDdSBYy0KfQl38fVHKy5oQRp36i6yMmClr+BPES8xH9ygz+OPFUX5xD6IeAuwdHQ6mpEmXPEijm7zA64ilSTtEZm3yoP7QXmPYfgFPxGc6Hn5Uzto1yjOlXycv9ygTZKTjza8/Ug/V6ZT96OoweERCHoRzUyKZ09h4cQ6GZFA6KWwQRCEoOARxw2GM64dBZCBVcQlHgeic8DI2CKxeIEC58sjIw5ANxbIe4UNGZLKKReWSo5BTrMOw5BaqRaL0pWMZX2RzXXC0Soc+XE7TA4YSfUgXhKMCcBSULrIhI2VJz4QtwjQG9Z5iefQD1R/xAL80EEY/fMWY0arSjHnAN06PcqMhSSYPW9FNHQihfInLD/8jNzyAw3IYNCrqFB/WZKOAevFKM6Zd1SlH+KX+Up5MLXJEB64no/0lDyB9S5PUyYs1Pe8UWRmrEyQjE/kSxB/gOfJFh+FlZPqEZ+oIvXc6kqwRMFoAVRlBvEcalA/6Q3c4DfJoh7fjy5ztA4vj8tK2jRdkRWaoWh7d+IM39I+RxHhC1F8Pa4St0CsF2Azux3QEpQd4jr6iAVY5o4cYtleQI7FcZpPNRxjYMCPKm2vuV/kQdJ971D1GUjiMc6Xz7sthAB7HDMicaRoaBMM8nAaMRdQprldEdtTgaez8TCJMSwAIASlYoSo8YWRUSYewNBIqOJUH0pwiFQCnQQWjoqkxVXEQ2fZD5D8CPUDw7wbF5IFoaMjnIwujVtmAI9+kRTwZaxk37isf6YTKzxZhftOCaSmMKM9IcxDAh/KJDo5yUd4WqDDwflrsnnI5rbyQB+PDdV1ZdILypcypL/QS6c1hjMCwHQZ5cI9zwrGLji8vK12hLu2qXFxTxugL/l1+00nfDqMEeZIm5Ygzo5w5yohA+/ElmasOg/KEV6ZoWN9jrY/2o/SURrf0eYacyEvdxHh6aOKU8V6O3QUWh62kMp4rdPysPVMOUSYQ+ao+87pj/GAkWWtj9KN6yzPqEDLTsWK0EdOqkxeQB4TuSAP9kSayc28QkBOcky4yU75yFLJhkq2bvDyDDz7LwxoonUtkp0zgcWCHARMoy98/+PzzYqeQGdqYTCeF9QLlx1HGkYZI7wOmUTK9Z+9F05A65EUBEF+FosJmaE6lxkEwn8u0C1NQOA+UjdKl6DocRLb9UNWhCDlVwdAHDZeeAFMgzKsiK2HqDDvxea5CpwJQMaLu1LgYNfJxR01FYVhUHoMgxoUH8dlOz54jsVL3c3sGSR5d9wM5OZwojoLeIYaORg8Ow2FQPuTFc0YYpM87Qv7ZeuNHcauoq2fiY1D5OyEaEOXLcT++eI7MVYeh9kjI+9bbfs8cJbagm6ES4jMnk3WYC8CkDx+Rqoh8RXkBcjESxnDKgFLG8EcbwoZQf5i+pdMc49fJC6oyq46rnA8KySwbpntCJ3nFDyNxZKWd+OinLN++HEYVBGeRi7k7RhkojWkM9UbBQYQnfeJzlMGnUULydjynclUVHs9FXNsJCTuPjB4whjgJpp5o1DgLjCNQPCGeHwbq1C++cQa+HmEFSc/Lp53sOGtOY8qICiz+SCempTQ8HQuH3nA2xOdaegJUMHTAlAJfBKYxxKHsoDqoxuU8Nt42vwpTk1eUqVcQB/mQ96L1Dq9evZpu377tBh4chsOgjGhoHHlnhXd0+Kld8mJeWWlXdRKhZ8qrfSwu/HxQKM9q3t14EQgjh/Fa6Xh1jeycYw/Yco4+kZlRh3juJQ/OD0vemH8dL5EPQBhkY2qG8sVZYHuQE5vE+gOdSzrL1CFeaGWKDxtSza8ObTmDzINCsWOOVR7q+FG+eoZsrCuyVkP5YifkLKjT6AOHMdBcA4aM4RrK1LCFDA8qvKB0MCwYLoy7Fq1wTu2XBu0ZhUQ44iA8fGAQZUyJT4+ZngAGkekCbZHlcyY8B8SLRvQ4gNSSg7l7DB4jK3486MqVK+mKGSgqMY6DiutxLLzkj5Au3NlYOpQRFYDrOjn92tLQm6HV9IYByUb+EPw5cV5e65meI2c7XB9EPE1nkVYVh1XKMig4FBqZfnFyEH2iK9dX0NmgpLSGDdJEZubiqafI7Pn0Ka/LWfKqunAQinL3A/FBb5s2g0NUJ1VlSPq0KY0+sIPcU0eoV0SZByW1nXivX5mJQxnSOVWnFHnq0ulrWy2IiaA+DLZ2GXEchOGIalwKiYKgt0svEMLIMy/JaIGeMds+WbiGB3Y50cPRIjbzizgMvfWsxS/SUQ+6CngQDRsxPz+za/JBb3ISzLljdKiQVEYaoY+urBKzl146jmlxTSHjKOUkROopVEcWEeiY3+lgZwm60fQceYhOEpCRRkCvCf2hT46A+qPP7lNnJGudXqogDBS3HqJvdO9lZHrmHNDLJl1IdRicNF0Cpoyon9RHZPf6anKrB+oO2ghd0r6QUR2ZkyIvfNJGvL5Yx4z5fMpXnU/VKdqUZKbGUK7YPmQ/KfKKR+oqsrjMZm8kM+UL8Rw5Vc59OQwyUaPiyDoClQJFYYgZlpFJVJjCDwLFJT3ywTnJYeAsaOyMNMjbp5lKR4GD4L0JnAXX4g0+NfVUB/I7CL9VdKo4ygeKBeKjNis05sJ5+VCjt3blrPCmNNA5z6nYFDZxRLFBE05pxLLUuY40gKgn5aHzUScgnTB1hx4wdBh47lNv6EDQsdB0pGTvRvafGwh6/KRJI4sOQ86ZfOXYgeouR+6dJF2K4Jm6hB7phdKrRW7uUe84QtQd2pkp1Le2qgXUpTkqpDKBqCP+4qu1Q86RkfsKpzamdoUNpO7INslJVvMYNUIW6ixyIKe2+ar+Eka2CZmR1ev5wCMMMjWiUrB/XwaZCoPCeF4EK8MPgBiXNEUUCvnIsOlIgal3rHNIYVWYzl8NDsJrPyAfpksoLPWAWWCjMXJkQRvjQ0HJ0FdBGqrAFCQFHUcT3COu4ku2KGM8RyeqRIrn+du1D3vt2oe+XBsprN4e9jB2JLzCVIk47Xg19/sl+I/xpRMR/LMxQLrhmjqAk6BzQWeDeqvPyLTTgSytOtJ2ZZw75YauIe6RD+RpmE79SDw79zSN0Kt45thO165HleATvhnh1o0wIMllimzHMcHa8tURqLt/VASPXkeMf+oH5UkPm04bHQLkQ5YYnnuE5cg19wHh7MLl5x7XMS7Q+XER/EpmNoQgI51SiFkNHAfl6LIYOBJWOuI40KI3meucRscuAdYEIM69h2FhPOEyecXpB/uxFnmJPMWjUM1/EH56QR3PkUcKgULzrbAYMis0N/R2rUKh0CDFieAaIg3CKLwaLvdVWVXwEVFnOucIYUwpO3rgmsbz9SIbobG7TL1kX9CsQvdC2ntAHuVpVaaXwvaAujjxHnmgGxoBRoCtkfSg0BEjVN6ARUZGoDgQ5JYOPB2jOq5IF73GdQoaHnmRPtOI0imdFUYx5EN+6FJ5qaOzXydmFIA8dAiQk0VRZKTOoVuMDUf0CtAtU33YAdYb0a9voihllpyjIK+MJ8Zfzl4bSqKz0BEZ5Vg4cp8ypEyR0d+u/vprl9+nditlfKxADsoRmYO9oEzdDpUyI6cg5wgRjvAHchiACkKjYAqIbbZ8oA/loSSg5GOcXtEra3Vp7xd3EH56QTVf8hGpguIcVBCxMGiECivonCMVFJKzgChUVfpqgYPqdSw/nUeeOafsmMbDwFGuNHqN2njuVIZ3hPiCp6m8y+cKFTmKMcWH86c0I/+VfLhSnAjuEQv9qDHQM9aIgOc+pWn1FOfIKIN6jEFjB6DX3U7pGj+MoBgFem+7bHBVh6Hwah/oEH2yxsY9jXzdmEAeY0Rh8uAwqLdaC6IeVh2G9ENdQVY2qnBkNIeO1eFAt0ctr5eI8QaPxelupwvefRei1RPOuY98CqewPEdWyptwKmdkQjY6BnrNQGtj+u6c51vmfeQo+ZT9wE7AvzqtXMv2CJwTBnmRW3W8b4cBiBKVhWKoEGwxYycSRoZGQYNQ8pGZYaEX1g8j3zq0eSnzU67kr4qpCsd0Bucy8jyDKMw6mWIa0Tlwrsqt+HWI5VVFp2eUKT0lKj/OQwYOEMf5JF4Nvw7C2HOlHMO375XHl9KpuwbxXgm/U3MfoA/0A0lnNAKOTKWRKjIhG71ESI4DuG78rAC5uK6M0D1TNCoTqOowAOmTJs5JL4miW3cUlr62n7p+RhGlLMikaVTVNZxlncPgiMGk/iCvryGaDg5zB95+cL7Kc2PA5dLuM+QRUVdi+XGuMJq+UTg9B8hER9kdZLmZgqn6TRxkEeBY5EZOP5TnLrPxTllKjqrMAJllr9qjCwszkMMAihYz4mNXbFnlpT4MjZyGUGXqpKNOda5UozpjRWVr90qtAFTphKjTmA4kR0HBtY1eTUGTRvVer4hxMZoaanNs9w5L1Mk+qhCv6BG90QgoC3pNyMtzGjjGDVnjSKob9Jxy6OQwCIPuSJM85HxPui5BN4eBzLR/9IncnHNfYUYBUZbqOTyK1PZ8jdHkrfKvuJJZbSaW8yjIHWUE1Wv44x71GWdC+VK2Gl24DPbf3lg9QtGiElAUowteXOLTCDQOelMKc9wKGzai6jiHkBHvjZL13SuUztENvSmewsB4RX0oLaWhQotOApIDqXMWQPEHQYyrnjeNHWIEyTUQr8Kg+R0VJJccb3QY3KNRIyM9w+gwusKeE4J0VVY4DKZsoj5IByKPaExoF+hYz8Go6xFEXrs5DIAeJTP6lcyEGUVZxbeOqi+0XbVj5OwEyhhCXo0k0YE6zaMms+SMgEdsDmULIbfslT+3SC/H6hNKAmWhID4x8fGdOz6nh+LwvDGbUaws+6GTmiQLClUFY/Tg3rlcHHMvbfcwLBGkGXXBOWkQjnSg6CwouCrE17B1qspPg8dZyMhxjzxFQMdRh8qH8tB6BveQSQ5Dc+2Srxe9RodRXcOI8WVA0aXywZhEnZ4UIBd1Gz1WHYaAXMiMvOgX2bmOso6SzOKdo9phNJ7UHbVhyVqVGVC2OA3kldNQGYNRk1mEzBAdKbdZ5chCzz28MX9g7qMiUAxvZLNjil0DEJ/goHG0My2PJwmd1KSKhWJxCjJG2mnBaINnGJQ6ublHGhwJQ1jiedzymvQhwgF4UVria9g6JV2IcoOo9FT+qpGLDaGKTver6DXcoFD66BCdujO3ckLH6BQZMGp0bmjkyNgPTyp/piygWDac60g+0iWk86hT6KRAnSH0iS4lp8A18iCjnIX0Kx1HOi6IZ46xPSMTR5yh2qHCwi/nOkbEMpbcUFXm4wZ8S2bZmigv95BZYf1ojB+Y82oSTEWxrY5dEnzRli+f4nFRWBVVZY8S6lQjBfsWtWDg8cbstFADihWM8FFOznWfMFAsMFVU7hMmxomAv+q9g0JpSnaOEAZNDZ1ziPsYBIXthP2eA4XpVZ5e0hQIK/2hZ5UXOpasNGychhp2P1CDU080yqC8dQ7JMZAP+Um30iV0EiA9QsgvWeMRIJdkjNM0UV6FPWrEsuJcZam2yDkU22EdJLPOJbOcRZ3Mxw34hWSDJDOEvJIZSLYDOwyiV5VIxcBBsGMAh8HHuVjbwJFIYVG5oJrGUaNODVWeuJZxZy0CT8yLYfS0aDRcM8pA4YRTnCooCKVDWDkIFZQqaTXuUemqrky5p0bAMVZ88VUFaeiZjsPivVOe3UDekPRLGYhHNW4ZboXfD8QlHOWmcgTVuAonKE9I58qX65OAWIdlXCRnN3kla6xDx4VqOaltirgmjMKJ12o8UH0mGZF3VDsE8IqMkNqEZI6AZ+4disPgnpwGowumpfh96CflS308I0zMuprGUaNODa4gjqVCUSaNA6fgIwochRFH/85TqWxIcLmUjh1jOhBGJg55FUcUIR6r94cN8qnLQ2UWdRXPTwqQTWXEeZTrIPKQpvRW1R/pxnvKJ+Z5kLyPA8gTCUhOHYUoo0iI58eNKI/4r5Mj3hOqz3TNUSTE8+NClIFzka4j4Nef28nQOFdSyoweG6MKvun09f3iN6KZJ+ZjgdHjRlQZPWxUeY78yPjjeXEIGHZNO8jQc4QII1RlkpNQb4yj4shxyFlUQVpHrZOI487/sHFY8tWlq3rxKuqzTrZXTd5e60qv4UYddXIcmsNQZswNs0OC9QwcBkcciBaDcBoRR63oyHMVGglg3Hmzly2Eeo9CvUmRUD2H5Cw030t6chKd4grS43HhuPM/bByWfHXpdqtrJx11sr1q8vZaV3oNN+qok2OoDkOIGeEQmIZipLFQflOHBXGumbLiEw3teWOLU6fmYSs/iqxz8tBowkcNZtD9w3XlKELrFBwx9uJJ8TlKbkjOpp1e6SR0Tw4nIvKSkZGRMWo4dIfBuRZ92IXCXnf/6JuNMp4+e9Z+uxanQtjITj+skV+v4aNB5hySgccp+LSTOQaOGhHwPI4qOoEwEHGI6wvj5RoF90FMA567pZeRkZExKjgShwFwGkxB8VILToNPh/gnpm2kgcPw0YYdfZ+2ha1jq5th5VknUerua5pIvX9GDmyLbdk56xW6Txg5izqQL88II6dTJaUhRDmirjIyMjJGGYfiMIRoDDln2omRBmsampLiHEfBSEOfZlgzx8KHyrQoLlI6OgfxHETjy7mu4zE6C3cURrw/gcPgRTv9+I0opilwT89JC8I5VB2NwlXTgO+6dDMyMjJGFUfmMADXkF6SguQwcCAQaxp6yQXnwhHCeUC6VloiAeOsI4TR1rmu5SzcYZTTRjgNjvArqkL3lVZ0FDqvOouIeA3PdXlkZGRkjCoO1WEAJR+NIwZf01M4C4761oy/CWqOgk8DrxsRDsJ5iLag0oHEUUg05hhsdw4cS2Mu4y5nwQ+JRGNP+Coi31VH4WlYfBFh5SgIV4V4zMjIyDiJOHSHIURjyTmEI8BJiKJj4FzOw4/hmTsMRhpyFuWR9ONLdm7YyyNOg51PchhyEN0MuByEHIDSjE5C1MlBgOwkMjIyXgUci8MAXEOMEHACmqZitMG5pp/4gRk5hDiaEHlaRYJY5vYPhbjzMOKbTzp3Z8K90glARfD6BXN3OCW1RyXBQRCvmlaE0qx7lpGRkXHScGQOQyC7qgHlnkYbOA1GFD6SwGGUTkLhQIzvZzXpCXXndekpTY0kIDmH6DA4z6OJjIyMbyOO3WEoexyDRhVyHhpt4Dyi4+iGqsHuNQ6kKSe9PyFngYOQI1HYKpRP3bOMjIyMVwFH7jCqqGbPNU6DUQbOQmsXGm3IcUDxXHF1LkQDLmMPaSopOgM5jDia4J7ixiMgr3idkZGR8SrjWB1GJ4PLfRyERhacR4r35ESi85BI0chDcg5yEDriGOQcovPgvBN/oO5ZRkZGxquKkXUYYkvnnRxHN4cB5CwgOQs5hegcRDGOzqtQ+nXPMjIyMl5VHPuUlNCLEZbTIGydk1AaOoJo/DViEEUHEsNFKK26ZxkZGRnfJpwYh1HH5qCsd8ojO4yMjIyMzhgZh1GHozbW2TlkZGRkdMZIO4yMjIyMjNFB/Te7MzIyMjIyKsgOIyMjIyOjJ2SHkZGRkZHRE7LDyMjIyMjoCdlhZGRkZGT0hOwwMjIyMjJ6QnYYGRkZGRk9ITuMjIyMjIyekB1GRkZGRkZPyA4jIyMjI6MnZIeRkZGRkdETssPIyMjIyOgJ2WFkZGRkZPSE7DAyMjIyMnpCdhgZGRkZGT0gpf8PdwIynVb0ttkAAAAASUVORK5CYII=';
    
    public function Create()
	{
		//Never delete this line!
		parent::Create();

		//These lines are parsed on Symcon Startup or Instance creation
		//You cannot use variables here. Just static values.

		$this->RegisterPropertyString("host", "");
		$this->RegisterPropertyInteger("port_zidoo", 9529);

        //we will wait until the kernel is ready
        $this->RegisterMessage(0, IPS_KERNELMESSAGE);
	}

	public function ApplyChanges()
	{
		//Never delete this line!
		parent::ApplyChanges();

        if (IPS_GetKernelRunlevel() !== KR_READY) {
            return;
        }

		$this->ValidateConfiguration();
	}

    /** @noinspection PhpMissingParentCallCommonInspection */
    public function MessageSink($TimeStamp, $SenderID, $Message, $Data)
    {
        switch ($Message) {
            case IM_CHANGESTATUS:
                if ($Data[0] === IS_ACTIVE) {
                    $this->ApplyChanges();
                }
                break;

            case IPS_KERNELMESSAGE:
                if ($Data[0] === KR_READY) {
                    $this->ApplyChanges();
                }
                break;

            default:
                break;
        }
    }


    /**
	 * Die folgenden Funktionen stehen automatisch zur Verfügung, wenn das Modul über die "Module Control" eingefügt wurden.
	 * Die Funktionen werden, mit dem selbst eingerichteten Prefix, in PHP und JSON-RPC wiefolgt zur Verfügung gestellt:
	 *
	 *
	 */

	private function ValidateConfiguration()
	{
		$host = $this->ReadPropertyString('host');

		//check IP
		if (!filter_var($host, FILTER_VALIDATE_IP) === false) {
			//IP ok
            $this->RegisterVariables();
			// Status Aktiv
			$this->SetStatus(IS_ACTIVE);
		} else {
			$this->SetStatus(203); //IP Adresse oder Host ist ungültig
		}
	}

    private function RegisterVariables(): void
    {
        $this->RegisterVariableBoolean("Status", "Power", "~Switch", $this->_getPosition());
        $this->EnableAction("Status");
        $zidoo_navi_ass = Array(
            Array(0, $this->Translate("Up"), "", -1),
            Array(1, $this->Translate("Left"), "", -1),
            Array(2, $this->Translate("Right"), "", -1),
            Array(3, $this->Translate("Down"), "", -1),
            Array(4, $this->Translate("Ok"), "", -1)
        );
        $this->RegisterProfileAssociation("Zidoo.Navigation", "Move", "", "", 0, 4, 0,0, VARIABLETYPE_INTEGER, $zidoo_navi_ass);
        $this->RegisterVariableInteger("ZidooNavigation", $this->Translate("Navigation"), "Zidoo.Navigation", $this->_getPosition());
        $this->EnableAction("ZidooNavigation");
        $zidoo_vol_ass = Array(
            Array(0, $this->Translate("Volume Up"), "", -1),
            Array(1, $this->Translate("Volume Down"), "", -1),
            Array(2, $this->Translate("Mute"), "", -1)
        );
        $this->RegisterProfileAssociation("Zidoo.Volume", "Intensity", "", "", 0, 2, 0, 0, VARIABLETYPE_INTEGER, $zidoo_vol_ass);
        $this->RegisterVariableInteger("ZidooVolume", $this->Translate("Volume"), "Zidoo.Volume", $this->_getPosition());
        $this->EnableAction("ZidooVolume");
        $zidoo_channel_ass = Array(
            Array(0, $this->Translate("Channel Up"), "", -1),
            Array(1, $this->Translate("Channel Down"), "", -1)
        );
        $this->RegisterProfileAssociation("Zidoo.Channel", "Execute", "", "", 0, 1, 0, 0, VARIABLETYPE_INTEGER, $zidoo_channel_ass);
        $this->RegisterVariableInteger("ZidooChannel", $this->Translate("Channel"), "Zidoo.Channel", $this->_getPosition());
        $this->EnableAction("ZidooChannel");
        $zidoo_color_ass = Array(
            Array(0, $this->Translate("Red"), "", 16711680),
            Array(1, $this->Translate("Green"), "", 65280),
            Array(2, $this->Translate("Yellow"), "", 16776960),
            Array(3, $this->Translate("Blue"), "", 255)
        );
        $this->RegisterProfileAssociation("Zidoo.Color", "Paintbrush", "", "", 0, 3, 0, 0, VARIABLETYPE_INTEGER, $zidoo_color_ass);
        $this->RegisterVariableInteger("ZidooColor", $this->Translate("Color"), "Zidoo.Color", $this->_getPosition());
        $this->EnableAction("ZidooColor");
        $zidoo_playback_ass = Array(
            Array(0, $this->Translate("Rewind"), "", -1),
            Array(1, $this->Translate("Pause"), "", -1),
            Array(2, $this->Translate("Play"), "", -1),
            Array(3, $this->Translate("Stop"), "", -1),
            Array(4, $this->Translate("Fast Forward"), "", -1),
            Array(5, $this->Translate("Repeat"), "", -1)
        );
        $this->RegisterProfileAssociation("Zidoo.Playback", "Script", "", "", 0, 5, 0, 0, VARIABLETYPE_INTEGER, $zidoo_playback_ass);
        $this->RegisterVariableInteger("ZidooPlayback", $this->Translate("Playback"), "Zidoo.Playback", $this->_getPosition());
        $this->EnableAction("ZidooPlayback");
        $zidoo_numeric_ass = Array(
            Array(0, "0", "", -1),
            Array(1, "1", "", -1),
            Array(2, "2", "", -1),
            Array(3, "3", "", -1),
            Array(4, "4", "", -1),
            Array(5, "5", "", -1),
            Array(6, "6", "", -1),
            Array(7, "7", "", -1),
            Array(8, "8", "", -1),
            Array(9, "9", "", -1)
        );
        $this->RegisterProfileAssociation("Zidoo.Numeric", "Calendar", "", "", 0, 9, 0, 0, VARIABLETYPE_INTEGER, $zidoo_numeric_ass);
        $this->RegisterVariableInteger("ZidooNumeric", $this->Translate("Numeric"), "Zidoo.Numeric", $this->_getPosition());
        $this->EnableAction("ZidooNumeric");
        $zidoo_menu_ass = Array(
            Array(0, $this->Translate("Home"), "", -1),
            Array(1, $this->Translate("Menu"), "", -1),
            Array(2, $this->Translate("Audio"), "", -1),
            Array(3, $this->Translate("Subtitle"), "", -1),
            Array(4, $this->Translate("Return"), "", -1),
            Array(5, $this->Translate("Info"), "", -1),
            Array(6, $this->Translate("Mouse"), "", -1)
        );
        $this->RegisterProfileAssociation("Zidoo.Menu", "Database", "", "", 0, 6, 0, 0, VARIABLETYPE_INTEGER, $zidoo_menu_ass);
        $this->RegisterVariableInteger("ZidooMenu", $this->Translate("Menu"), "Zidoo.Menu", $this->_getPosition());
        $this->EnableAction("ZidooMenu");
        $zidoo_scene_ass = Array(
            Array(0, $this->Translate("Apps"), "", -1),
            Array(1, $this->Translate("Movie"), "", -1),
            Array(2, $this->Translate("Music"), "", -1),
            Array(3, $this->Translate("Photo"), "", -1),
            Array(4, $this->Translate("File Explorer"), "", -1)
        );
        $this->RegisterProfileAssociation("Zidoo.Scene", "Popcorn", "", "", 0, 4, 0, 0, VARIABLETYPE_INTEGER, $zidoo_scene_ass);
        $this->RegisterVariableInteger("ZidooScene", $this->Translate("Scene"), "Zidoo.Scene", $this->_getPosition());
        $this->EnableAction("ZidooScene");
    }

	public function RequestAction($Ident, $Value)
	{
		$this->SetValue($Ident, $Value);
		switch ($Ident) {
			case "Status":
				if($Value)
				{
					$this->PowerOn();
				}
				else{
					$this->PowerOff();
				}
				break;
			case "ZidooNavigation":
				if($Value == 0)
				{
					$this->Up();
				}
				elseif($Value == 1)
				{
					$this->Left();
				}
				elseif($Value == 2)
				{
					$this->Right();
				}
				elseif($Value == 3)
				{
					$this->Down();
				}
				elseif($Value == 4)
				{
					$this->Ok();
				}
				break;
			case "ZidooVolume":
				if($Value == 0)
				{
					$this->VolumeUp();
				}
				elseif($Value == 1)
				{
					$this->VolumeDown();
				}
				elseif($Value == 2)
				{
					$this->Mute();
				}
				break;
			case "ZidooChannel":
				if($Value == 0)
				{
					$this->ChannelUp();
				}
				elseif($Value == 1)
				{
					$this->ChannelDown();
				}
				break;
			case "ZidooColor":
				if($Value == 0)
				{
					$this->Red();
				}
				elseif($Value == 1)
				{
					$this->Green();
				}
				elseif($Value == 2)
				{
					$this->Yellow();
				}
				elseif($Value == 3)
				{
					$this->Blue();
				}
				break;
			case "ZidooPlayback":
				if($Value == 0)
				{
					$this->Previous();
				}
				elseif($Value == 1)
				{
					$this->Pause();
				}
				elseif($Value == 2)
				{
					$this->Play();
				}
				elseif($Value == 3)
				{
					$this->Stop();
				}
				elseif($Value == 4)
				{
					$this->Next();
				}
				elseif($Value == 5)
				{
					$this->Repeat();
				}
				break;
			case "ZidooNumeric":
				if($Value == 0)
				{
					$this->Key0();
				}
				elseif($Value == 1)
				{
					$this->Key1();
				}
				elseif($Value == 2)
				{
					$this->Key2();
				}
				elseif($Value == 3)
				{
					$this->Key3();
				}
				elseif($Value == 4)
				{
					$this->Key4();
				}
				elseif($Value == 5)
				{
					$this->Key5();
				}
				elseif($Value == 6)
				{
					$this->Key6();
				}
				elseif($Value == 7)
				{
					$this->Key7();
				}
				elseif($Value == 8)
				{
					$this->Key8();
				}
				elseif($Value == 9)
				{
					$this->Key9();
				}
				break;
			case "ZidooMenu":
				if($Value == 0)
				{
					$this->Home();
				}
				elseif($Value == 1)
				{
					$this->Menu();
				}
				elseif($Value == 2)
				{
					$this->Audio();
				}
				elseif($Value == 3)
				{
					$this->Subtitle();
				}
				elseif($Value == 4)
				{
					$this->Back();
				}
				elseif($Value == 5)
				{
					$this->Info();
				}
				elseif($Value == 6)
				{
					$this->Mouse();
				}
				break;
			case "ZidooScene":
				if($Value == 0)
				{
					$this->AppSwitch();
				}
				elseif($Value == 1)
				{
					$this->Movie();
				}
				elseif($Value == 2)
				{
					$this->Music();
				}
				elseif($Value == 3)
				{
					$this->Photo();
				}
				elseif($Value == 4)
				{
					$this->FileExplorer();
				}
				break;
			default:
				$this->SendDebug("Zidoo", "Invalid ident", 0);
		}
	}

	// Commands

	/**
	 * Menu
	 * @return bool|string
	 */
	public function Menu()
	{
		$command = "Key.Menu"; // menu alternative "Key"
        return $this->SendCommandtoZidoo($command);
	}


	/**
	 * Back
	 * @return bool|string
	 */
	public function Back()
	{
		$command = "Key.Back"; // back
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Cancel
	 * @return bool|string
	 */
	public function Cancel()
	{
		$command = "Key.Cancel"; // Cancel
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Home
	 * @return bool|string
	 */
	public function Home()
	{
		$command = "Key.Home"; // home
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Up
	 * @return bool|string
	 */
	public function Up()
	{
		$command = "Key.Up"; // up
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Down
	 * @return bool|string
	 */
	public function Down()
	{
		$command = "Key.Down"; // down
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Right
	 * @return bool|string
	 */
	public function Right()
	{
		$command = "Key.Right"; // right
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Left
	 * @return bool|string
	 */
	public function Left()
	{
		$command = "Key.Left"; // left
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Ok
	 * @return bool|string
	 */
	public function Ok()
	{
		$command = "Key.Ok"; // ok
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Select
	 * @return bool|string
	 */
	public function Select()
	{
		$command = "Key.Select"; // select
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Star
	 * @return bool|string
	 */
	public function Star()
	{
		$command = "Key.Star"; // star
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Pound
	 * @return bool|string
	 */
	public function Pound()
	{
		$command = "Key.Pound"; // pound
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Dash
	 * @return bool|string
	 */
	public function Dash()
	{
		$command = "Key.Dash"; // dash
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Media Play
	 * @return bool|string
	 */
	public function Play()
	{
		$command = "Key.MediaPlay"; // play
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Media Stop
	 * @return bool|string
	 */
	public function Stop()
	{
		$command = "Key.MediaStop"; // stop
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Media Pause
	 * @return bool|string
	 */
	public function Pause()
	{
		$command = "Key.MediaPause"; // pause
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Media Next
	 * @return bool|string
	 */
	public function Next()
	{
		$command = "Key.MediaNext"; // next
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Media Previous
	 * @return bool|string
	 */
	public function Previous()
	{
		$command = "Key.PopMenu"; // previous
        return $this->SendCommandtoZidoo($command);
	}


	/**
	 * Number 0
	 * @return bool|string
	 */
	public function Key0()
	{
		$command = "Key.Number_0"; // 0
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Number 1
	 * @return bool|string
	 */
	public function Key1()
	{
		$command = "Key.Number_1"; // 1
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Number 2
	 * @return bool|string
	 */
	public function Key2()
	{
		$command = "Key.Number_2"; // 2
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Number 3
	 * @return bool|string
	 */
	public function Key3()
	{
		$command = "Key.Number_3"; // 3
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Number 4
	 * @return bool|string
	 */
	public function Key4()
	{
		$command = "Key.Number_4"; // 4
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Number 5
	 * @return bool|string
	 */
	public function Key5()
	{
		$command = "Key.Number_5"; // 5
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Number 6
	 * @return bool|string
	 */
	public function Key6()
	{
		$command = "Key.Number_6"; // 6
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Number 7
	 * @return bool|string
	 */
	public function Key7()
	{
		$command = "Key.Number_7"; // 7
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Number 8
	 * @return bool|string
	 */
	public function Key8()
	{
		$command = "Key.Number_8"; // 8
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Number 9
	 * @return bool|string
	 */
	public function Key9()
	{
		$command = "Key.Number_9"; // 9
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Red
	 * @return bool|string
	 */
	public function Red()
	{
		$command = "Key.UserDefine_A"; // red
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Green
	 * @return bool|string
	 */
	public function Green()
	{
		$command = "Key.UserDefine_B"; // green
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Yellow
	 * @return bool|string
	 */
	public function Yellow()
	{
		$command = "Key.UserDefine_C"; // yellow
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Blue
	 * @return bool|string
	 */
	public function Blue()
	{
		$command = "Key.UserDefine_D"; // blue
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Mute
	 * @return bool|string
	 */
	public function Mute()
	{
		$command = "Key.Mute"; // mute
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Volume Up
	 * @return bool|string
	 */
	public function VolumeUp()
	{
		$command = "Key.VolumeUp"; // volume up
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Volume Down
	 * @return bool|string
	 */
	public function VolumeDown()
	{
		$command = "Key.VolumeDown"; // volume down
        return $this->SendCommandtoZidoo($command);
	}


	/**
	 * Power On
	 * @return bool|string
	 */
	public function PowerOn()
	{
		$command = "Key.PowerOn"; // power
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Backward
	 * @return bool|string
	 */
	public function Backward()
	{
		$command = "Key.MediaBackward"; // backward
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Forward
	 * @return bool|string
	 */
	public function Forward()
	{
		$command = "Key.MediaForward"; // forward
        return $this->SendCommandtoZidoo($command);
	}


	/**
	 * Info
	 * @return bool|string
	 */
	public function Info()
	{
		$command = "Key.Info"; // info
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Record
	 * @return bool|string
	 */
	public function Record()
	{
		$command = "Key.Record"; // record
        return $this->SendCommandtoZidoo($command);
	}


	/**
	 * Page up
	 * @return bool|string
	 */
	public function PageUp()
	{
		$command = "Key.PageUP"; // page/chapter up
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Page down
	 * @return bool|string
	 */
	public function PageDown()
	{
		$command = "Key.PageDown"; // page/chapter down
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Subtitle
	 * @return bool|string
	 */
	public function Subtitle()
	{
		$command = "Key.Subtitle"; // subtitle
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Audio
	 * @return bool|string
	 */
	public function Audio()
	{
		$command = "Key.Audio"; // audio
        return $this->SendCommandtoZidoo($command);
	}


	/**
	 * Repeat
	 * @return bool|string
	 */
	public function Repeat()
	{
		$command = "Key.Repeat"; // repeat
        return $this->SendCommandtoZidoo($command);
	}


	/**
	 * Mouse
	 * @return bool|string
	 */
	public function Mouse()
	{
		$command = "Key.Mouse"; // mouse
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Popup Menu
	 * @return bool|string
	 */
	public function PopupMenu()
	{
		$command = "Key.PopMenu"; // popup menu
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Movie
	 * @return bool|string
	 */
	public function Movie()
	{
		$command = "Key.movie"; // movie
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Music
	 * @return bool|string
	 */
	public function Music()
	{
		$command = "Key.music"; // music
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Photo
	 * @return bool|string
	 */
	public function Photo()
	{
		$command = "Key.photo"; // photo
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * File Explorer
	 * @return bool|string
	 */
	public function FileExplorer()
	{
		$command = "Key.file"; // file explorer
        return $this->SendCommandtoZidoo($command);
	}


	/**
	 * Light
	 * @return bool|string
	 */
	public function Light()
	{
		$command = "Key.light"; // light
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Resolution
	 * @return bool|string
	 */
	public function Resolution()
	{
		$command = "Key.Resolution"; // display mode
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Reboot
	 * @return bool|string
	 */
	public function Reboot()
	{
		$command = "Key.PowerOn.Reboot"; // reboot
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Power Off
	 * @return bool|string
	 */
	public function PowerOff()
	{
		$command = "Key.PowerOn.Poweroff"; // power off
        return $this->SendCommandtoZidoo($command);
	}

	/**
	 * Standby
	 * @return bool|string
	 */
	public function Standby()
	{
		$command = "Key.PowerOn.Standby"; // power
		return $this->SendCommandtoZidoo($command);
	}

	/**
	 * PIP
	 * @return bool|string
	 */
	public function PIP()
	{
		$command = "Key.Pip"; // pip
		return $this->SendCommandtoZidoo($command);
	}


	/**
	 * Screenshot
	 * @return bool|string
	 */
	public function Screenshot()
	{
		$command = "Key.Screenshot"; // screenshot
        return $this->SendCommandtoZidoo($command);
	}


	/**
	 * App switch
	 * @return bool|string
	 */
	public function AppSwitch()
	{
		$command = "Key.APP.Switch"; // multitasking
        return $this->SendCommandtoZidoo($command);
	}

	public function ChannelDown()
	{
		$command = "Key.PageDown"; // channel down
        return $this->SendCommandtoZidoo($command);
	}

	public function ChannelUp()
	{
		$command = "Key.PageUP"; // channel up
        return $this->SendCommandtoZidoo($command);
	}

	protected function SendCommandtoZidoo($command)
	{
		$ip = $this->ReadPropertyString("host");
		$port_zidoo = $this->ReadPropertyInteger("port_zidoo");
		$data = file_get_contents("http://".$ip.":".$port_zidoo."/ZidooControlCenter/RemoteControl/sendkey?key=".$command);
		$this->SendDebug("Zidoo Send", "http://".$ip.":".$port_zidoo."/ZidooControlCenter/RemoteControl/sendkey?key=".$command, 0);
		$this->SendDebug("Zidoo Response", $data, 0);
		return $data;
	}


    /***********************************************************
     * Configuration Form
     ***********************************************************/

    /**
     * build configuration form
     * @return string
     */
    public function GetConfigurationForm()
    {
        // return current form
        return json_encode([
            'elements' => $this->FormHead(),
            'actions' => $this->FormActions(),
            'status' => $this->FormStatus()
        ]);
    }

    /**
     * return form configurations on configuration step
     * @return array
     */
    protected function FormHead()
    {
        $form = [
            [
                'type' => 'Image',
                'image' => 'data:image/png;base64, ' . self::PICTURE_LOGO_ZIDOO],
            [
                'type' => 'Label',
                'caption' => 'IP adress of Zidoo'
            ],
            [
                'name' => 'host',
                'type' => 'ValidationTextBox',
                'caption' => 'IP Zidoo'
            ]
        ];
        return $form;
    }


    /**
     * return form actions by token
     * @return array
     */
    protected function FormActions()
    {
        $form = [
            [
                'type' => 'TestCenter'
            ]
        ];

        return $form;
    }

    /**
     * return from status
     * @return array
     */
    protected function FormStatus()
    {
        $form = [
            [
                'code' => IS_CREATING,
                'icon' => 'inactive',
                'caption' => 'Creating instance.'
            ],
            [
                'code' => IS_ACTIVE,
                'icon' => 'active',
                'caption' => 'Zidoo accessible.'
            ],
            [
                'code' => IS_INACTIVE,
                'icon' => 'inactive',
                'caption' => 'interface closed.'
            ],
            [
                'code' => 202,
                'icon' => 'error',
                'caption' => 'Zidoo IP adress must not empty.'
            ],
            [
                'code' => 203,
                'icon' => 'error',
                'caption' => 'No valid IP adress.'
            ],
            [
                'code' => 205,
                'icon' => 'error',
                'caption' => 'field must not be empty.'
            ]
        ];

        return $form;
    }

}